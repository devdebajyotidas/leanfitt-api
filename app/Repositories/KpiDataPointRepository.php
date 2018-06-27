<?php

namespace App\Repositories;


use App\Models\KpiDataPoint;
use App\Repositories\Contracts\KpiDataPointRepositoryInterface;

class KpiDataPointRepository extends BaseRepository implements KpiDataPointRepositoryInterface
{
    public function model()
    {
        return new KpiDataPoint();
    }

    public function filterDataPoint($start, $end,$kpi_id)
    {
        $query=$this->model()->whereBetween('target_date',[$start,$end])->where('kpi_id',$kpi_id)->get();
        return $query;
    }
}