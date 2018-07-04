<?php

namespace App\Repositories\Contracts;


interface ReportDefaultsRepositoryInterface
{
    public function getDefault($report_id,$level);
}