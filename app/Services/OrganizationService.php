<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use App\Repositories\MediaRepository;
use App\Repositories\OrganizationAdminRepository;
use App\Repositories\OrganizationRepository;
use App\Services\Contracts\OrganizationServiceInterface;
use Illuminate\Support\Facades\DB;

class OrganizationService implements OrganizationServiceInterface
{
    protected $organiztionRepo;
    protected $adminRepo;
    protected $orgAdminRepo;
    protected $mediaRepo;
    public function __construct(OrganizationRepository $organizationRepository,
                                OrganizationAdminRepository $organizationAdminRepository,
                                AdminRepository $adminRepository,
                                MediaRepository $mediaRepository)
    {
        $this->orgAdminRepo=$organizationAdminRepository;
        $this->organiztionRepo=$organizationRepository;
        $this->adminRepo=$adminRepository;
        $this->mediaRepo=$mediaRepository;
    }

    public function all()
    {
        $response=new \stdClass();
        $query=$this->organiztionRepo->withCount('employees')->withCount('departments')->withCount('project')->get();
        if(!empty($query)){
            $response->success=true;
            $response->data=$query;
            $response->message="Organizations found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Organizations not found";
        }

        return $response;
    }

    public function updateOrganization($request, $org)
    {
        $response=new \stdClass();
        if(empty($org)){
            $response->success=false;
            $response->message="Invalid organization selection";
            return $response;
        }

        if(empty($request->all())){
            $response->success=false;
            $response->message="Invalid data";
            return $response;
        }

        DB::beginTransaction();
        if($request->has('image') && $request->get('image') != null)
        {
            $file = $request->get('image');
            $image_base64 = base64_decode($file);
            $extension=$media['mime_type']=$file->getClientOriginalExtension();
            $name =$media['file_name']= time() . rand(100,999) . $extension;
            $path = public_path() . '/uploads/organization/' . $name;
            $media['name']=$featured_image=url('/uploads/organization').'/'.$name;
            if(file_put_contents($path, $image_base64)){
                $this->mediaRepo->create($media);
            }
        }
        else{
            $featured_image=null;
        }

        $data=$request->all();
        if(!empty($featured_image)){
            $data['featured_image']=$featured_image;
        }
        $query=$this->organiztionRepo->update($org,$data);
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Organization has bee updated";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went worng, try again later";
        }

        return $response;
    }

    public function details($organization)
    {
        $response=new \stdClass();
        if(empty($organization)){
            $response->success=false;
            $response->data=null;
            $response->message="Invalid organization selection";
            return $response;
        }

        $query=$this->organiztionRepo->find($organization)->with('employees','project','departments','organizationAdmin.admin')->first();
        if($query){
            $response->success=true;
            $response->data=$query;
            $response->message="Organization found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No details available";
        }

        return $response;
    }

    public function changeAdmin($employee_id, $org)
    {
        $response=new \stdClass();
        if(empty($org)){
            $response->success=false;
            $response->message="organization_id is required";
            return $response;
        }

        if(empty($employee_id)){
            $response->success=false;
            $response->message="employee_id is required";
            return $response;
        }

        DB::beginTransaction();
        $user_id=$this->adminRepo->getUser($employee_id,'employee');
        $admin=$this->adminRepo->where('user_id',$user_id)->first();
        if(count($admin) > 0){
            $query=$this->orgAdminRepo->where('organization_id',$org)->first()->update(['admin_id'=>$admin->id]);
        }
        else{
            $admin_data['user_id']=$user_id;
            $admin_re=$this->adminRepo->create($admin_data);
            $query=$this->orgAdminRepo->where('organization_id',$org)->first()->update(['admin_id'=>$admin_re->id]);
        }

        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Admin has been changed";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, tray again later";
        }

        return $response;
    }

    public function list(){
        $response=new \stdClass();
        $query=$this->organiztionRepo->where('is_archived',0)->get();
        if($query){
            $data=$query->map(function($item){
                return ['id'=>$item['id'],'name'=>$item['name']];
            });
            $response->success=true;
            $response->data=$data;
            $response->message="Organization found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Organization not found";
        }

        return $response;
    }

    public function removeOrganization($org_id,$user_id)
    {
        $response=new \stdClass();
        if(empty($org_id)){
            $response->success=false;
            $response->messge="Invalid organization selection";
            return $response;
        }

        $query=$this->organiztionRepo->find($org_id)->history()->forceDelete();

        if($query){
             $response->success=true;
             $response->message="Organization has been deleted";
        }
        else{
            $response->success=true;
            $response->message="Something went wrong, try again later";
        }

        return $response;
        /*Affected-> organization,admins,projects,projects->actio items->realated,employees,dpartments,quiz result*/
    }
}