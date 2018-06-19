<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Support\Collection;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{

    public function model(){
        return new Department();
    }

    public function getAllDepartmentsByOrganization($organization): Collection
    {
        $result=$this->model()->where('organization_id',$organization)->get();
        return $result;
    }

    public function getArchivedDepartmentByOrganization($organization): Collection
    {
        $result=$this->model()->where('organization_id',$organization)->where('is_archived',1)->get();
        return $result;
    }

    public function getActiveDepartmentByOrganization($organization): Collection
    {
        $result=$this->model()->where('organization_id',$organization)->where('is_archived',0)->get();
        return $result;
    }

    /*Add*/

    /*update*/

    /*archive*/

    /*restore*/

    /*remove*/
}