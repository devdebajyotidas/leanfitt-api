<?php

namespace App\Repositories;

use App\Models\QuizResult;
use App\Repositories\Contracts\QuizRepositoryInterface;

class QuizRepository extends BaseRepository implements QuizRepositoryInterface
{

    public function model()
    {
        return new QuizResult();
    }

    public function allTaken()
    {
        $query=$this->model()->join('employees as emp','emp.id','quiz_results.employee_id')
            ->join('users as u','u.id','=','emp.user_id')
            ->join('departments as dep','dep.id','=','emp.department_id')
            ->join('organizations as org','org.id','=','dep.organization_id')
            ->join('lean_tools as lt','lt.id','=','quiz_results.lean_tool_id')
            ->select(['u.first_name','u.last_name','u.email','u.avatar','quiz_results.*','lt.name as tool_name','dep.id as department_id','dep.name as department_name','org.id as organization_id','org.name as organizaton_name']);

        return $query;
    }
}