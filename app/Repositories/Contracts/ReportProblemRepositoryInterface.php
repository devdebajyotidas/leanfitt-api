<?php

namespace App\Repositories\Contracts;


interface ReportProblemRepositoryInterface
{
    public function getProblems($report_id);
}