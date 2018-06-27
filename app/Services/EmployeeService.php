<?php

namespace App\Services;


use App\Mail\InvitationMail;
use App\Repositories\EmployeeRepository;
use App\Repositories\InvitationRepository;
use App\Repositories\UserRepository;
use App\Services\Contracts\EmployeeServiceInterface;
use App\Validators\InvitationValidator;
use App\Validators\UserValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class EmployeeService implements EmployeeServiceInterface
{
    protected $empRepo;
    protected $inviteRepo;
    protected $userRepo;
    public function __construct(EmployeeRepository $employeeRepository,
                                InvitationRepository $invitationRepository,
                                UserRepository $userRepository)
    {
        $this->empRepo=$employeeRepository;
        $this->inviteRepo=$invitationRepository;
        $this->userRepo=$userRepository;
    }

    public function index($request)
    {
        $response=new \stdClass();
        $organization=$request->get('organization');
        $department=$request->get('department');

        $query=$this->empRepo->getEmployees();
        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
            $invited=$this->inviteRepo->where('organization_id',$organization)->where('is_joined',0)->get();
            if($invited){
                $invited_col=$invited->map(function($item){
                   return  [
                       "id"=> null,
                       "user_id"=> null,
                       "department_id"=> $item['department_id'],
                       "designation"=> null,
                       "is_archived"=> 0,
                       "created_at"=> Carbon::parse($item['created_at'])->format('Y-m-d H:i:s'),
                       "updated_at"=> Carbon::parse($item['updated_at'])->format('Y-m-d H:i:s'),
                       "organization_id"=> $item['organization_id'],
                       "department_name"=> null,
                       "first_name"=> $item['first_name'],
                       "last_name"=> $item['last_name'],
                       "full_name"=>$item['first_name']. " ".$item['last_name'],
                       "email"=> $item['email'],
                       "phone"=> $item['phone'],
                       "avatar"=> "https://ui-avatars.com/api/?name=".$item['first_name'],
                       "status"=> "Invited"
                     ];
                });
            }
            else{
                $invited_col=null;
            }
        }

        if(!empty($department)){
            $query=$query->where('department_id',$department);
        }

        $data= $query->orderBy('created_at','desc')->get();
        $data=$data->map(function($item){
            $item=collect($item);
            $return=$item->except('user')->toArray();
            $return['status']='Joined';
            return $return;
        });

        if(isset($invited_col) && count($invited_col) > 0){
             $data=$data->merge($invited_col->toArray());
        }

        if($data->count() > 0){
            $response->success=true;
            $response->data=$data;
            $response->message="Employees available";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No employees available";
        }

        return $response;
    }

    public function show($employee_id)
    {
        $response=new \stdClass();
        if(empty($employee_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Invalid employee selection";
            return $response;
        }

        $query=$this->empRepo->showEmployee($employee_id);
        if(!empty($query)){
            $response->success=true;
            $response->data=$this->formatEmployeeData($query);
            $response->message='Employee found';
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message='Something went wrong, try again later';
        }

        return $response;
    }

    public function formatEmployeeData($query){
        $data['user_id']=$query->user_id;
        $data['employee_id']=$query->id;
        $data['first_name']=$query->first_name;
        $data['last_name']=$query->last_name;
        $data['designation']=$query->designation;
        $data['email']=$query->email;
        $data['phone']=$query->phone;
        $data['avatar']=$query->avatar;
        $data['department_id']=isset($query->department) ? $query->department_id : null;
        $data['department_name']=isset($query->department) ? $query->department->name : null;
        $data['organization_id']=isset($query->department->organization) ? $query->department->organization->id : null;
        $data['organization_name']=isset($query->department->organization) ? $query->department->organization->name : null;
        $data['active_subscription']=isset($query->subscription) ? $query->subscription->is_active ==1 ? true : false : false;
        $data['is_archived']=$query->is_archived;
        $data['created_at']=$query->created_at;
        return $data;
    }

    public function changeDepartment($request)
    {
        $response=new \stdClass();
        if(empty($request->get('employee_id'))){
            $response->success=false;
            $response->message="Please select an employee first";
            return $response;
        }

        if(empty($request->get('department_id'))){
            $response->success=false;
            $response->message="Please select an department";
            return $response;
        }

        $emp=$this->empRepo->find($request->get('employee_id'));
        if($emp->count() > 0){
            $query=$this->empRepo->fillUpdate($emp,['department_id'=>$request->get('department_id')]);
            if($query){
                $response->success=true;
                $response->message="Department has been changed";
            }
            else{
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }
        }
        else{
            $response->success=false;
            $response->message="Selected employee could not be found";
        }

        return $response;
    }

    public function list($request)
    {
        $response=new \stdClass();
        $organization=$request->get('organization');
        $department=$request->get('department');

        $query=$this->empRepo->getEmployees();
        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }

        if(!empty($department)){
            $query=$query->where('department_id',$department);
        }

        $query=$query->where('employees.is_archived',0)->get();

        $data=$query->map(function($item){
            return ['id'=>$item['id'],'full_name'=>$item['full_name']];
        });

        if($data->count() > 0){
            $response->success=true;
            $response->data=$data->sortBy('full_name');
            $response->message="List available";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="List not available";
        }

        return $response;
    }

    public function invite($request)
    {
        $response=new \stdClass();
        $validator=new InvitationValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $exist_email=$this->inviteRepo->where('email',$request->get('email'))->exists();
        if($exist_email){
            $response->success=false;
            $response->message="This user already invited";
            return $response;
        }

        $exist_phone=$this->inviteRepo->where('phone',$request->get('phone'))->exists();
        if($exist_phone){
            $response->success=false;
            $response->message="This user already invited";
            return $response;
        }

        $exist_user_email=$this->userRepo->where('email',$request->get('email'))->exists();
        if($exist_user_email){
            $response->success=false;
            $response->message="Email already been taken";
            return $response;
        }

        $exist_user_phone=$this->userRepo->where('phone',$request->get('phone'))->exists();
        if($exist_user_phone){
            $response->success=false;
            $response->message="Phone already been taken";
            return $response;
        }

        $data=$request->all();
        $data['token']=md5(time());
        $data['code']=substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -1).random_int(11111,99999).substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -2);
        DB::beginTransaction();
        $log=$this->inviteRepo->create($data);
        if($log){
            Mail::to($request->get('email'))->send(new InvitationMail($data));
            DB::commit();
            $response->success=true;
            $response->message="An user has been invited";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function join($request)
    {
        $response=new \stdClass();
        if(empty($request->get('code'))){
            $response->success=false;
            $response->message="Invitation code is required";
            return $response;
        }

        $invitation=$this->inviteRepo->where('code',$request->get('code'))->first();
        if($invitation){
            $data=$request->all();
            $data['first_name']=$invitation->first_name;
            $data['last_name']=$invitation->last_name;
            $data['department_id']=$invitation->department_id;
            $data['organization_id']=$invitation->organization_id;
            $data['email']=$invitation->email;
            $data['phone']=$invitation->phone;

            $validator=new UserValidator($data,'create');
            if($validator->fails()){
                $response->success=false;
                $response->message=$validator->messages()->first();
                return $response;
            }

            DB::beginTransaction();
            $data['verification_token']=md5(time());
            $data['is_verified']=1;
            $user=$this->userRepo->create($data);
            if($user){
                $data['user_id']=$user->id;
                $employee=$this->empRepo->create($data);
                if($employee){
                    $this->inviteRepo->fillUpdate($invitation,['is_joined'=>1]);
                    DB::commit();
                    $response->success=true;
                    $response->message="You have successfully joined as an employee";
                }
                else{
                    DB::rollBack();
                    $response->success=false;
                    $response->message="Something went wrong, try again later";
                }
            }
            else{
                DB::rollBack();
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }
        }
        else{
            $response->success=false;
            $response->message="Invalid invitation code";
        }

        return $response;

    }

    public function archive($employee_id)
    {
        $response=new \stdClass();
        if(empty($employee_id)){
            $response->success=false;
            $response->message="Invalid employee selection";
            return $response;
        }

        $employee=$this->empRepo->find($employee_id);
        if($employee){
            $update_employee=$this->empRepo->fillUpdate($employee,['is_archived'=>1]);
            $update_user=$this->userRepo->update($employee->user_id,['is_archived'=>1]);
            if($update_user && $update_employee){
                $response->success=true;
                $response->message="Account has been archived";
            }
            else{
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }
        }
        else{
            $response->success=false;
            $response->message="Unable to find the account";
        }

        return $response;
    }

    public function restore($employee_id)
    {
        $response=new \stdClass();
        if(empty($employee_id)){
            $response->success=false;
            $response->message="Invalid employee selection";
            return $response;
        }

        $employee=$this->empRepo->find($employee_id);
        if($employee){
            $update_employee=$this->empRepo->fillUpdate($employee,['is_archived'=>0]);
            $update_user=$this->userRepo->update($employee->user_id,['is_archived'=>0]);
            if($update_user && $update_employee){
                $response->success=true;
                $response->message="Account has been archived";
            }
            else{
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }
        }
        else{
            $response->success=false;
            $response->message="Unable to find the account";
        }

        return $response;
    }

    public function delete($employee_id, $user_id)
    {
        // TODO: Implement delete() method.
    }
    public function subscribe($employee_id)
    {
        // TODO: Implement subscribe() method.
    }
}