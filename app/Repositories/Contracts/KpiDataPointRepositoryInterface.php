<?php

namespace App\Repositories\Contracts;


interface KpiDataPointRepositoryInterface
{
    public function filterDataPoint($start,$end,$kpi_id);
}