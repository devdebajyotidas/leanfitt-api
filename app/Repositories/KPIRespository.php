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

    public function allKpi()
    {
        $query=$this->model()->join('projects as p','p.id','kpi_charts.project_id')->select(['kpi_charts.*','p.organization_id']);
        return $query;
    }
}