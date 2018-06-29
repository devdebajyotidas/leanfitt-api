<?php

namespace App\Services;


use App\Repositories\AwardRepository;
use App\Services\Contracts\AwardServiceInterface;

class AwardService implements AwardServiceInterface
{
    protected $repo;
    public function __construct(AwardRepository $awardRepository)
    {
        $this->repo=$awardRepository;
    }

    public function allAwards($request)
    {
        $response=new \stdClass();
        $department=$request->get('department');
        $organization=$request->get('organization');
        $employee=$request->get('employee');
        $user=$request->get('user');

        $awards=$this->repo->getAwards();

        if(!empty($department)){
            $awards=$awards->where('department_id',$department);
        }

        if(!empty($organization)){
            $awards=$awards->where('organization_id',$organization);
        }

        if(!empty($employee)){
            $awards=$awards->where('employee_id',$employee);
        }

        if(!empty($user)){
            $awards=$awards->where('user_id',$user);
        }

        $data= $awards->orderby('created_at','desc')->get();

        if(count($data) > 0){
            $response->success=true;
            $response->data=$data;
            $response->message="Awards found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No awards found";
        }

        return $response;
    }
}