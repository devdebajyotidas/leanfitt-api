<?php

namespace App\Repositories\Contracts;


interface ReportDefaultAssignemntRepositoryInterface
{
    public function getAssignments($report_id);
}