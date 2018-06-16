<?php

namespace App\Repositories;

use App\Models\LeanTool;
use App\Repositories\Contracts\QuizRepositoryInterface;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Mixed_;

class QuizRepository extends BaseRepository implements QuizRepositoryInterface
{

    public function model()
    {
        return new LeanTool();
    }

    public function getQuizItems($tool)
    {
        $result=$this->model()->find($tool);
        return $result->quiz;
    }
}