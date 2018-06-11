<?php

namespace App\Repositories\Contracts;


use Illuminate\Support\Collection;

interface QuizRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAllQuizzes():Collection;

}