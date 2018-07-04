<?php

namespace App\Repositories;


use App\Models\ReportElementAssignment;
use App\Repositories\Contracts\ReportElementAssignmentRepositoryInterface;

class ReportElementAssignemtnRepository extends BaseRepository implements ReportElementAssignmentRepositoryInterface
{
    public function model()
    {
        return new ReportElementAssignment();
    }

    public function getAssignments($default_id)
    {
        $query=$this->model()
            ->join('report_default_elements as rd','rd.id','=','report_element_assignments.report_default_element_id')
            ->select(['report_element_assignments.id','report_element_assignments.report_id','report_element_assignments.report_default_id','report_element_assignments.report_default_element_id','report_element_assignments.level','rd.label']);
        return $query;
    }
}