<?php

namespace App\Repositories\Contracts;


use App\Models\LeanTool;
use Illuminate\Support\Collection;

interface QuizRepositoryInterface
{

    public function getAllQuiz($user):Collection;

    /**
     * @param int|LeanTool $tool
     */
    public function getQuizItems($tool);

}