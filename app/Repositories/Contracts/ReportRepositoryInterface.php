<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ReportRepositoryInterface
{
    public function allReports();

    public function showReport($report_id);

    public function getCategory($report_id);
}