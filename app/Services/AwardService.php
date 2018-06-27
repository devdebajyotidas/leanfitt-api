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
        $department=$request->get('department');
        $organization=$request->get('organization');
        $employee=$request->get('employee');

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

        return $awards->orderby('created_at','desc')->get();
    }
}