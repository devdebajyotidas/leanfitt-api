<?php

namespace App\Services\Contracts;

interface QuizResultServiceInterface
{
    /**
     * @param $data
     * @return bool
     */
    public function addQuizResult($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function updateQuizResult($data):bool;
}