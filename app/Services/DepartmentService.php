<?php

namespace App\Services;


use App\Repositories\DepartmentRepository;
use App\Services\Contracts\DepartmentServiceInterface;
use App\Validators\DepartmentValidator;

class DepartmentService implements DepartmentServiceInterface
{
    protected $departmentRepo;
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepo=$departmentRepository;
    }

    public function departments($filter)
    {
        $response=new \stdClass();
        $organization=$filter->get('organization');

        $query=$this->departmentRepo->getDepartments();
        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }
        if($query){
            $response->success=true;
            $response->data = $query->orderBy('name','asc')->get();
            $response->message="Department found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No departments available";
        }

        return $response;
    }

    public function list($filter){
        $response=new \stdClass();
        $organization=$filter->get('organization');

        $query=$this->departmentRepo->getDepartments();
        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }
        $data=$query->where('is_archived',0)->orderBy('name','asc')->get();;
        if($data){
            $response->success=true;
            $response->data =$data->map(function($item){
                return ['id'=>$item['id'],'name'=>$item['name']];
            });
            $response->message="Department found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No departments available";
        }

        return $response;
    }

    public function details($department_id)
    {
        $response=new \stdClass();
        if(empty($department_id)){
            $response->success=false;
            $response->message="Invalid department selection";
            return $response;
        }

        $query=$this->departmentRepo->where('id',$department_id)->with('organization')->first();
        if($query){
            $response->success=true;
            $response->data=$query;
            $response->message="Department found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function addDepartment($request)
    {
        $response=new \stdClass();
        $validator=new DepartmentValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $query=$this->departmentRepo->create($request->all());
        if($query){
            $response->success=false;
            $response->message="New department has been added";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function updateDepartment($request, $id)
    {
        $response=new \stdClass();
        $validator=new DepartmentValidator($request->all(),'update');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $query=$this->departmentRepo->update($id,$request->all());
        if($query){
            $response->success=false;
            $response->message="Department has been updated";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function archiveDepartment($id)
    {
        $response=new \stdClass();
        if(empty($id)){
            $response->success=false;
            $response->message="Invalid department selection";
            return $response;
        }

        $query=$this->departmentRepo->archive($id);
        if($query){
            $response->success=true;
            $response->message='Department has been archived';
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function restoreDepartment($id)
    {
        $response=new \stdClass();
        if(empty($id)){
            $response->success=false;
            $response->message="Invalid department selection";
            return $response;
        }

        $query=$this->departmentRepo->restore($id);
        if($query){
            $response->success=true;
            $response->message='Department has been restored';
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function removeDepartment($id)
    {
        $response=new \stdClass();
        if(empty($id)){
            $response->success=false;
            $response->message="Invalid department selection";
            return $response;
        }

        $query=$this->departmentRepo->forceDelete($id);
        if($query){
            $response->success=true;
            $response->message='Department has been removed';
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }
}