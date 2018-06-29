<?php

namespace App\Repositories;

use App\Models\Award;
use App\Models\Employee;
use App\Models\Organization;
use App\Repositories\Contracts\AwardRepositoryInterface;
use Illuminate\Support\Collection;

class AwardRepository extends BaseRepository implements AwardRepositoryInterface
{

    public function model()
    {
        return new Award();
    }

    public function getAwards(){
        $query=$this->model()->join('employees as emp','emp.id','=','awards.employee_id')
            ->join('users as u','u.id','=','emp.user_id')
            ->join('departments as dep','dep.id','=','emp.department_id')
            ->select(['awards.*','u.id as user_id','u.first_name','u.last_name','u.avatar','emp.department_id','dep.organization_id']);
        return $query;
    }
}