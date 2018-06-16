<?php

namespace App\Repositories\Contracts;


use App\Models\LeanTool;
use Illuminate\Support\Collection;

interface QuizRepositoryInterface
{

    /**
     * @param int|LeanTool $tool
     */
    public function getQuizItems($tool);
}