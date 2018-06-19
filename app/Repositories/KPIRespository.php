<?php

namespace App\Repositories;

use App\Models\KpiChart;
use App\Repositories\Contracts\KPIRepositoryInterface;
use Illuminate\Support\Collection;

class KPIRespository extends BaseRepository implements KPIRepositoryInterface
{

    public function model()
    {
        return new KpiChart();
    }

    public function getAllKpiByProject($project): Collection
    {
        $result=$this->model()->where('project_id',$project)->get(['title','id']);
        return $result;
    }

    public function getKpiInformation($kpi)
    {
        $result=$this->model()->find($kpi);
        return $result;
    }

    public function getKpiDataPoints($kpi,$start_date,$end_date): Collection
    {
        $result=$this->model()->find($kpi)->kpiData()->whereBetween('target_date', [$start_date, $end_date])->get();
        return $result;
    }

    /*Add*/

    /*update*/

}