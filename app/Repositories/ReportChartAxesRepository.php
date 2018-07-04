<?php

namespace App\Repositories;


use App\Models\ReportChartAxis;
use App\Repositories\Contracts\ReportChartAxesRepositoryInterface;

class ReportChartAxesRepository extends BaseRepository implements ReportChartAxesRepositoryInterface
{
    public function model()
    {
        return new ReportChartAxis();
    }

    public function getChart($report_id)
    {
        $query=$this->model()->with(['chart'=>function($query){
            $query->select('report_charts.id','label','value');
        }])->where('report_id',$report_id)->first();
        return $query;
    }
}