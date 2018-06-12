<?php

namespace App\Repositories;

use App\Models\QuizResult;
use App\Repositories\Contracts\QuizResultRepositoryInterface;
use Illuminate\Support\Collection;

class QuizResultRepository extends BaseRepository implements QuizResultRepositoryInterface
{

    public function model()
    {
        return new QuizResult();
    }

    public function getAllQuizTaken(): Collection
    {
        // TODO: Implement getAllQuizTaken() method.
    }

    public function getAllQuizTakenByUser($user): Collection
    {
        // TODO: Implement getAllQuizTakenByUser() method.
    }

    public function getAllQuizTakenByDepartment($organization, $department): Collection
    {
        // TODO: Implement getAllQuizTakenByDepartment() method.
    }

    public function getAllQuizTakenByOrganization($organization): Collection
    {
        // TODO: Implement getAllQuizTakenByOrganization() method.
    }

    public function getQuizResult($quizTaken): float
    {
        // TODO: Implement getQuizResult() method.
    }
}