<?php

namespace App\Repositories;


use App\Models\ReportProblem;
use App\Repositories\Contracts\ReportProblemRepositoryInterface;

class ReportProblemRepository extends BaseRepository implements ReportProblemRepositoryInterface
{
    public function model()
    {
       return new ReportProblem();
    }

    public function getProblems($report_id)
    {
        $query=$this->model()->with('reason')->where('report_id',$report_id)->get();
        return $query;
    }
}