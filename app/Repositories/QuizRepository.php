<?php

namespace App\Repositories;

use App\Models\LeanTool;
use App\Repositories\Contracts\QuizRepositoryInterface;
use Illuminate\Support\Collection;

class QuizRepository extends BaseRepository implements QuizRepositoryInterface
{

    public function model()
    {
        return new LeanTool();
    }

    public function getAllQuizzes(): Collection
    {
        // TODO: Implement getAllQuizzes() method.
    }

    public function getQuizItems($tool): Collection
    {
        // TODO: Implement getQuizItems() method.
    }
}