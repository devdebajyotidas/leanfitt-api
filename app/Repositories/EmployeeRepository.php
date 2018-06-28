<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function model()
    {
        return new Employee();
    }

    public function getEmployees()
    {
        $query=$this->model()
            ->join('departments as dep','dep.id','=','employees.department_id')
            ->join('users as u','u.id','=','employees.user_id')
            ->select(['employees.*','dep.organization_id','dep.name as department_name','u.first_name','u.last_name','u.email','u.phone','u.avatar']);
        return $query;
    }

    public function showEmployee($employee_id)
    {
        $query=$this->model()->with(['user','department.organization','subscription'])->where('id',$employee_id)->first();
        return $query;
    }

    public function checkEmployee($user,$organization=null)
    {
        $query= $this->model()->where('user_id',$user)->with('department.organization')->first();
        return $query;
    }
}