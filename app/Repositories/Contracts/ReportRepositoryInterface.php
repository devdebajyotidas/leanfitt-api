<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ReportRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllReports():Collection;

    /**
     * @param int|Project $project
     * @return Collection
     */
    public function getAllReportsByProject($project):Collection;

    /**
     * @param Repo$report
     * @return Collection
     */
    public function getReportDetails($report):Collection;
}