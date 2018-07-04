<?php

namespace App\Repositories;


use App\Models\ReportDefaultAssignment;
use App\Repositories\Contracts\ReportDefaultAssignemntRepositoryInterface;

class ReportDefaultAssignmentRepository extends BaseRepository implements ReportDefaultAssignemntRepositoryInterface
{
    public function model()
    {
        return new ReportDefaultAssignment();
    }

    public function getAssignments($report_id)
    {
        $query=$this->model()
            ->join('report_defaults as rd','rd.id','=','report_default_assignments.report_default_id')
            ->select(['report_default_assignments.id','report_default_assignments.level','rd.label'])
            ->where('report_default_assignments.report_id',$report_id);
        return $query;
    }
}