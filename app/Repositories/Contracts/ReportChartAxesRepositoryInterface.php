<?php

namespace App\Repositories\Contracts;


interface ReportChartAxesRepositoryInterface
{
    public function getChart($report_id);
}