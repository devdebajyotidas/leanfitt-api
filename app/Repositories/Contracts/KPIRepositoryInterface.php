<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface KPIRepositoryInterface
{
   public function getAllKpiByProject($project):Collection;

   public function getKpiInformation($kpi);

   public function getKpiDataPoints($kpi,$start_date,$end_date):Collection;

}