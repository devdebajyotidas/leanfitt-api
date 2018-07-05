<?php

namespace App\Repositories;


use App\Models\AssessmentResult;
use App\Repositories\Contracts\AssessmentRepositoryInterface;

class AssessmentRepository extends BaseRepository implements AssessmentRepositoryInterface
{
    public function model()
    {
        return new AssessmentResult();
    }

    public function allAssessment()
    {
        $query=$this->model()
            ->join('lean_tools as ln','ln.id','=','assessment_results.lean_tool_id')
            ->join('employees as emp','emp.id','=','assessment_results.employee_id')
            ->join('users as u','u.id','=','emp.user_id')
            ->join('departments as dep','dep.id','=','emp.department_id')
            ->select([
                'assessment_results.*',
                'ln.name as tool_name',
                'ln.featured_image as tool_image',
                'u.id as user_id',
                'u.first_name as employee_first_name',
                'u.last_name as employee_last_name',
                'u.first_name as employee_avatar',
                'dep.id as department_id',
                'dep.name as depart_name',
                'dep.organization_id'
                ]);

        return $query;
    }
}