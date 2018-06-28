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

            if($user->is_verified==0){
                $response->success=false;
                $response->data=null;
                $response->message="Email address is not verified";
                $response->redirect='verify';
                return $response;
            }

            if($user){
                $user_data=$request->all();
                $user_data['user_id']=$user->id;
                $this->updateDevice($user_data);
                $account=$this->defaultAccount($user->id);
                $data=array_merge($user->toArray(),$account);

                $response->success=true;
                $response->data=collect($data)->except('verification_token');
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
            $this->deviceRepo->fillUpdate($device,['fcm_token'=>$request['fcm_token']]);
        }
        else{
            $this->deviceRepo->create($request);
        }
    }

    public function defaultAccount($user_id,$organization=null,$role=null){
        $admin_data=$employee_data=null;
        $admin=$this->orgAdminRepo->firstOrganizationByAdmin($user_id,$organization);
        if($admin){
            $admin_data= ['organization_name'=>$admin['name'],'organization_id'=>$admin['id'],'admin_id'=>$admin['admin_id'],'role'=>'admin','is_superadmin'=>$admin['is_superadmin']];
        }

        $employee=$this->employeeRepo->checkEmployee($user_id);
        if(isset($employee['department']['organization']['id']) && !empty($organization)){
            if($employee['department']['organization']['id']!=$organization){
                $employee=null;
            }
        }
        if($employee){
            $employee_data['organization_name']=$employee['department']['organization']['name'];
            $employee_data['organization_id']=$employee['department']['organization']['id'];
            $employee_data['employee_id']=$employee['id'];
            $employee_data['role']='employee';
            $employee_data['is_superadmin']=0;
        }
        else{
            $employee_data=null;
        }

        if(!empty($role)){
            if($role=='admin'){
                return $admin_data;
            }
            elseif($role=='employee'){
                return $employee_data;
            }
            else{
                return null;
            }
        }
        else{
            if($admin){
                return $admin_data;
            }
            else{
                return $employee_data;
            }
        }
    }

    public function switchAccount($request)
    {
        $response=new \stdClass();
        if(empty($request->get('user_id'))){
            $response->success=false;
            $response->data=null;
            $response->message='user_id is required';
            return $response;
        }

        if(empty($request->get('organization_id'))){
            $response->success=false;
            $response->data=null;
            $response->message='organization_id is required';
            return $response;
        }

        if(empty($request->get('role'))){
            $response->success=false;
            $response->data=null;
            $response->message='role is required';
            return $response;
        }

        $user=$this->repo->find($request->get('user_id'))->toArray();
        $account=$this->defaultAccount($request->get('user_id'),$request->get('organization_id'),$request->get('role'));

        if($account && $user){
            $data=array_merge($user,$account);
            $response->success=true;
            $response->data=$data;
            $response->message="Account available";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Account not available";
        }

        return $response;
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


    public function checkResetCode($code){
        $response=new \stdClass();
        if(empty($code)){
            $response->success=false;
            $response->data=null;
            $response->message="Please enter the recovery code";
            return $response;
        }

        $recovery_log=$this->recoveryRepo->where('code',$code)->first();
        if($recovery_log) {
            $account = $this->repo->find($recovery_log->user_id);
            if($account){
                $response->success=true;
                $response->data=['user_id'=>$account->id];
                $response->message="Account found";
            }
            else{
                $response->success=false;
                $response->data=null;
                $response->message="Account not found";
            }
        }
        else{
            $response->success=true;
            $response->data=null;
            $response->message="Invalid code";
        }

        return $response;
    }


    public function updatePassword($request)
    {
        $response=new \stdClass();
        if(empty($request->get('user_id'))){
            $response->success=false;
            $response->message="Invalid user id";
            return $response;
        }

        $account=$this->repo->find($request->get('user_id'));

        $validator=new UserValidator($request->all(),'update');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        if($account){
            $data=$request->except('user_id');
            $query=$this->repo->fillUpdate($account,$data);
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

        return $response;
    }
}