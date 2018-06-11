<?php

namespace App\Repositories\Contracts;


use App\Models\LeanTool;
use Illuminate\Support\Collection;

interface QuizRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAllQuizzes():Collection;

    /**
     * @param int|LeanTool $tool
     * @return Collection
     */
    public function getQuizItems($tool):Collection;
}