<?php
namespace App\Services;

use App\Repositories\AdminRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\MediaRepository;
use App\Repositories\OrganizationAdminRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\UserRepository;
use App\Services\Contracts\UserServiceInterface;
use App\Validators\EmployeeValidator;
use App\Validators\UserValidator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserService implements UserServiceInterface
{
    protected $userRepo;
    protected $employeeRepo;
    protected $adminRepo;
    protected $orgAdminRepo;
    protected $organizationRepo;
    protected $mediaRepo;
    public function __construct(UserRepository $userRepository,
                                EmployeeRepository $employeeRepository,
                                AdminRepository $adminRepository,
                                OrganizationAdminRepository $organizationAdminRepository,
                                OrganizationRepository $organizationRepository,
                                MediaRepository $mediaRepository)
    {
        $this->userRepo=$userRepository;
        $this->employeeRepo=$employeeRepository;
        $this->adminRepo=$adminRepository;
        $this->organizationRepo=$organizationRepository;
        $this->orgAdminRepo=$organizationAdminRepository;
        $this->mediaRepo=$mediaRepository;
    }

    public function signup($request)
    {
        $response=new \stdClass();

        $validator=new UserValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $exist_email=$this->userRepo->where('email',$request->get('email'))->exists();
        if($exist_email){
            $response->success=false;
            $response->message="Email already been taken";
            return $response;
        }

        $exist_phone=$this->userRepo->where('phone',$request->get('phone'))->exists();
        if($exist_phone){
            $response->success=false;
            $response->message="Phone has already been taken";
            return $response;
        }

        DB::beginTransaction();
        $user_data=$request->all();
        $user_data['verification_token']=md5(time());
        $user=$this->userRepo->create($user_data);
        if($user){
            $data['user_id']=$user->id;
            $admin=$this->adminRepo->create($data);
            $contact_person=$user->first_name.' '.$user->last_name;
            $organization=$this->organizationRepo->create(['contact_person'=>$contact_person]);
            $org_data['organization_id']=$organization->id;
            $org_data['admin_id']=$admin->id;
            $orgadmin=$this->orgAdminRepo->create($org_data);
            if($admin && $organization && $orgadmin){
                DB::commit();
                $response->success=true;
                $response->message="Successfully registered";
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

        return $response;
    }

    public function accounts($user_id)
    {
        $response=new \stdClass();
        if(empty($user_id)){
            $response->success=false;
            $response->message="Invalid user selection";
            return $response;
        }

        $admins=$this->orgAdminRepo->AllOrganizationByAdmin($user_id);
        $data=$admins->map(function($item){
           return ['organization_name'=>$item['name'],'organization_id'=>$item['id'],'role'=>'admin'];
        });

        $employee=$this->employeeRepo->checkEmployee($user_id);
        if($employee){
            $data_employee['organization_name']=$employee['name'];
            $data_employee['organization_id']=$employee['id'];
            $data_employee['role']='employee';
            $data=$data->push(new Collection($data_employee));
        }

        return $data;
    }

    public function profile($user_id)
    {
        $response=new \stdClass();
        if(empty($user_id)){
            $response->success=false;
            $response->message="Invalid account selection";
            return $response;
        }

        $query=$this->userRepo->profile($user_id);

        if($query){
            if(count($query['employee']) > 0){
                $is_employee=true;
                $department=$query['employee']['department']['name'];
                $department_id=$query['employee']['department']['id'];
            }
            else{
                $is_employee=false;
                $department=$department_id=null;
            }
            $data= [
                'full_name'=>$query['first_name'].' '.$query['last_name'],
                'email'=>$query['email'],
                'phone'=>$query['phone'],
                'avatar'=>$query['avatar'],
                'is_verified'=>$query['is_verified'],
                'is_employee'=>$is_employee,
                'department_name'=>$department,
                'department_id'=>$department_id,
                'is_admin'=>count($query['admin']['organizationAdmin'][0]['organization']) > 0 ? true : false,
                'organization_count'=>count($query['admin']['organizationAdmin'][0]['organization']),
                'organizations'=>isset($query['admin']['organizationAdmin'][0]['organization']) ? $query['admin']['organizationAdmin'][0]['organization'] : null,
                'assignee_count'=>$query['assignee_count'],
                'award_count'=>$query['award_count'],
                'quiz_count'=>$query['quiz_count'],
            ];

            $response->success=true;
            $response->data=$data;
            $response->message="Profile found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function update($request, $user_id)
    {
        $response=new \stdClass();
        $validator=new UserValidator($request->all(),'update');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        if(empty($user_id)){
            $response->success=false;
            $response->message="Invalid user selection";
            return $response;
        }

        DB::beginTransaction();
        if($request->has('image') && $request->get('image') != null)
        {
            $file = $request->get('image');
            $image_base64 = base64_decode($file);
            $extension=$media['mime_type']=$file->getClientOriginalExtension();
            $name =$media['file_name']= time() . rand(100,999) . $extension;
            $path = public_path() . '/uploads/profile/' . $name;
            $media['name']=$featured_image=url('/uploads/profile').'/'.$name;
            if(file_put_contents($path, $image_base64)){
                $this->mediaRepo->create($media);
            }
        }
        else{
            $featured_image=null;
        }

        $data=$request->all();
        if(!empty($featured_image)){
            $data['avatar']=$featured_image;
        }

        $query=$this->userRepo->update($user_id,$data);
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Profile has been updated";
            return $response;
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
            return $response;
        }
    }

    public function deactivate($user_id) //Find all association
    {
        $response=new \stdClass();
        if(empty($user_id)){
            $response->success=false;
            $response->message="Invalid account selection";
            return $response;
        }

        DB::beginTransaction();
        $user=$this->userRepo->find($user_id);
        $query=$user->forceDelete($user_id);
        if($query){
            Mail::to($user->email);
            DB::commit();
            $response->success=true;
            $response->message="Account has been deactivated";
            return $response;
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
            return $response;
        }
    }

    public function joinEmployee($request)
    {
        $response=new \stdClass();
        $validator=new EmployeeValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $exists=$this->employeeRepo->where('user_id',$request->get('user_id'))->exists();
        if($exists){
            $response->success=false;
            $response->message="You have already joined as employee";
            return $response;
        }

        DB::beginTransaction();
        $query=$this->employeeRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="You've joined as employee";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }
}