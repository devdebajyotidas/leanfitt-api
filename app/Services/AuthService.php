<?php

namespace App\Services;


use App\Mail\PasswordResetMail;
use App\Repositories\DeviceRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\OrganizationAdminRepository;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use App\Services\Contracts\AuthServiceInterface;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthService implements AuthServiceInterface
{
    protected $repo;
    protected $deviceRepo;
    protected $orgAdminRepo;
    protected $employeeRepo;
    protected $recoveryRepo;
    public function __construct(UserRepository $userRepository,
                                DeviceRepository $deviceRepository,
                                OrganizationAdminRepository $organizationAdminRepository,
                                EmployeeRepository $employeeRepository,
                                PasswordResetRepository $passwordResetRepository)
    {
        $this->repo=$userRepository;
        $this->deviceRepo=$deviceRepository;
        $this->orgAdminRepo=$organizationAdminRepository;
        $this->employeeRepo=$employeeRepository;
        $this->recoveryRepo=$passwordResetRepository;
    }

    public function login($request)
    {
        $response=new \stdClass();
        if($request->get('password') && Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], true))
        {
            $user = Auth::user();
//            if($user->is_deactivated==1){
//                $response->success=true;
//                $response->data=$user->load('user', 'department.organization');
//                $response->message="Successfully logged in";
//            }

            if($user->is_archived==1){
                $response->success=false;
                $response->data=null;
                $response->message="Account is suspended";
                $response->redirect='suspended';
                return $response;
            }

            if($user){
                $user_data=$request->all();
                $user_data['user_id']=$user->id;
                $this->updateDevice($user_data);
                $account=$this->defaultAccount($user->id);
                $data=array_merge($user->toArray(),$account);

                $response->success=true;
                $response->data=$data;
                $response->message="Successfully logged in";
                $response->redirect='home';
            }
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Email and Password does not match";
            $response->redirect='login';
        }

        return $response;
    }

    protected function updateDevice($request){
        $device=$this->deviceRepo->where('user_id',$request['user_id'])->where('uuid',$request['uuid'])->first();
        if($device){
            $this->deviceRepo->fillUpdate($device,['fcm_token'=>$request['fcm_token'],'api_token'=>$request['api_token']]);
        }
        else{
            $this->deviceRepo->create($request);
        }
    }

    public function defaultAccount($user_id,$organization=null){
        $admin=$this->orgAdminRepo->firstOrganizationByAdmin($user_id,$organization);
        if($admin){
            $data= ['organization_name'=>$admin['name'],'organization_id'=>$admin['id'],'role'=>'admin','is_superadmin'=>$admin['is_superadmin']];
        }
        else{
            $employee=$this->employeeRepo->checkEmployee($user_id);
            if(isset($employee) && !empty($organization)){
                if($employee['id']!=$organization){
                    $employee=null;
                }
            }

            if($employee){
                $data['organization_name']=$employee['name'];
                $data['organization_id']=$employee['id'];
                $data['role']='employee';
                $data['is_superadmin']=0;
            }
            else{
                $data=null;
            }
        }

        return $data;
    }

    public function switchAccount($request)
    {
        $response=new \stdClass();
        if(empty($request->get('user_id'))){
            $response->success=false;
            $response->data=null;
            $response->message='Invalid user selection';
            return $response;
        }

        if(empty($request->get('organization_id'))){
            $response->success=false;
            $response->data=null;
            $response->message='Invalid organization selection';
            return $response;
        }

        $user=$this->repo->find($request->get('user_id'))->toArray();
        $account=$this->defaultAccount($request->get('user_id'),$request->get('organization_id'));
        $data=array_merge($user,$account);

        if($account){
            $response->success=true;
            $response->data=$data;
            $response->message="Account available";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Account not available";
        }
    }

    public function recovery($request)
    {
        $response=new \stdClass();
        if(empty($request->get('email'))){
            $response->success=false;
            $response->message="Invalid email address";
            return $response;
        }

        $account=$this->repo->where('email',$request->get('email'))->first();
        if($account){
            $data['first_name']=$account->first_name;
            $data['email']=$request->get('email');
            $data['token']=$data['request_id']=md5(time());
            $data['code']=random_int(111111,999999).substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -2);
            $data['user_id']=$account->id;
            $log=$this->recoveryRepo->create($data);
            if($log){
                Mail::to($request->get('email'))->send(new PasswordResetMail($data));
                $response->success=true;
                $response->message="An email has been sent to the registered email address";
            }
            else{
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }

        }
        else{
            $response->success=false;
            $response->message="Unable to find your account";
        }

        return $response;
    }

    public function updatePassword($request, $code)
    {
        $response=new \stdClass();
        if(empty($code)){
            $response->success=false;
            $response->message="Incorrect recovery code";
            return $response;
        }

        $recovery_log=$this->recoveryRepo->where('code',$code)->first();
        if($recovery_log){
            $account=$this->repo->find($recovery_log->user_id);

            $validator=new UserValidator($request->all(),'update');
            if($validator->fails()){
                $response->success=false;
                $response->message=$validator->messages()->first();
                return $response;
            }

            if($account){
                $query=$this->repo->fillUpdate($account,$request->all());
                if($query){
                    $response->success=true;
                    $response->message="Password has been updated";
                }
                else{
                    $response->success=false;
                    $response->message="Unable to update password";
                }
            }
            else{
                $response->success=false;
                $response->message="Account not found";
            }
        }
        else{
            $response->success=false;
            $response->message="Incorrect recovery code";
        }

        return $response;
    }
}