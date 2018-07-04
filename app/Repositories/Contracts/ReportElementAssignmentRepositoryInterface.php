<?php

namespace App\Repositories\Contracts;


interface ReportElementAssignmentRepositoryInterface
{
   public function getAssignments($report_id);
}