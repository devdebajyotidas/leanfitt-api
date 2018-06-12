<?php

namespace App\Services\Contracts;

interface QuizTakenServiceInterface
{
    /**
     * @param $data
     * @return bool
     */
    public function addQuizTaken($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function updateQuizTaken($data):bool;
}