<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Support\Collection;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return new Employee();
    }

    public function getAllEmployees(): Collection
    {
        $result=$this->model()->all();
        return $result;
    }

    public function getActiveEmployees(): Collection
    {
        $result=$this->model()->where('is_archived',0)->get();
        return $result;
    }

    public function getArchivedEmployees(): Collection
    {
        $result=$this->model()->where('is_archived',1)->get();
        return $result;
    }

    public function getEmployeesByDepartment($department): Collection
    {
        $result=$this->model()->where('department_id',$department)->get();
        return $result;
    }

    public function getActiveEmployeesByDepartment($department): Collection
    {
        $result=$this->model()->where('is_archived',0)->where('department_id',$department)->get();
        return $result;
    }

    public function getArchivedEmployeesByDepartment($department): Collection
    {
        $result=$this->model()->where('is_archived',1)->where('department_id',$department)->get();
        return $result;
    }

    public function getEmployeesByOrganization($organization): Collection
    {
        $result=$this->model()->where('organization_id',$organization)->get();
        return $result;
    }

    public function getActiveEmployeesByOrganization($organization): Collection
    {
        $result=$this->model()->where('is_archived',0)->where('organization_id',$organization)->get();
        return $result;
    }

    public function getArchivedEmployeesByOrganization($organization): Collection
    {
        $result=$this->model()->where('is_archived',1)->where('organization_id',$organization)->get();
        return $result;
    }

    public function isArchived($employee): bool
    {
        $result=$this->model()->find($employee)->where('is_archived',1)->exists();
        return $result;
    }

    public function hasSubscription($employee): bool
    {
       //Need to be revisited
    }

    /*Add*/

    /*update*/

    /*archive*/

    /*restore*/

    /*remove*/

    public function changeDepartment($employee, $department)
    {
        return $this->model()->find($employee)->update(['department_id'=>$department]);
    }

}