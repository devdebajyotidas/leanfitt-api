<?php

namespace App\Services;

use App\Repositories\QuizResultRepository;
use App\Services\Contracts\QuizResultServiceInterface;

class QuizResultService implements QuizResultServiceInterface
{
    protected $quizResultRepository;
    public function __construct(QuizResultRepository $quizResultRepository)
    {
        $this->quizResultRepository=$quizResultRepository;
    }

    public function addQuizResult($data): bool
    {
        // TODO: Implement addQuizResult() method.
    }

    public function updateQuizResult($data): bool
    {
        // TODO: Implement updateQuizResult() method.
    }

}