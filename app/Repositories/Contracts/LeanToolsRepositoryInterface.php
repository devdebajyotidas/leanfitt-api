<?php

namespace App\Repositories\Contracts;


use App\Models\LeanTool;
use Illuminate\Support\Collection;

interface LeanToolsRepositoryInterface
{
    public function allQuiz($employee_id);

    public function allAssessment($employee_id);

    public function getQuiz($tool_id,$employee_id);

    public function getAssessment($tool_id,$employee_id);
}