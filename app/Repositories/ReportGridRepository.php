<?php

namespace App\Repositories;


use App\Models\ReportGrid;
use App\Repositories\Contracts\ReportGridRepoistoryInterface;

class ReportGridRepository extends BaseRepository implements ReportGridRepoistoryInterface
{
    public function model()
    {
        return new ReportGrid();
    }

    public function allGrids($report_id)
    {
        $query=$this->model()->where('report_id',$report_id)->get();
        return $query;
    }
}