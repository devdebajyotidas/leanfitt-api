<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface KPIRepositoryInterface
{
   public function getAllKpiByProject($project):Collection;
   public function getKpiInformation($kpi):Collection;
   public function getKpiDataPoints($kpi):Collection;
   public function getKpiQuote($kpi):Collection;
}