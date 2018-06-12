<?php

namespace App\Repositories\Contracts;

use App\Models\Department;
use App\Models\Organization;
use App\Models\QuizTaken;
use Illuminate\Support\Collection;

interface QuizTakenRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllQuizTaken():Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function getAllQuizTakenByOrganization($organization):Collection;

    /**
     * @param int|User $user
     * @return Collection
     */
    public function getAllQuizTakenByUser($user):Collection;

    /**
     * @param int|Organization $organization
     * @param int|Department $department
     * @return Collection
     */
    public function getAllQuizTakenByDepartment($organization,$department):Collection;

    /**
     * @param int|QuizTaken $quizTaken
     * @return float
     */
    public function getQuizResult($quizTaken):float;
}