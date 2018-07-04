<?php

namespace App\Repositories;


use App\Models\ReportChart;
use App\Repositories\Contracts\ReportChartRepositoryInterface;

class ReportChartRepository extends BaseRepository implements ReportChartRepositoryInterface
{
    public function model()
    {
       return new ReportChart();
    }
}