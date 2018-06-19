<?php

namespace App\Repositories\Contracts;

use App\Models\Department;
use App\Models\Organization;
use Illuminate\Support\Collection;

interface AwardRepositoryInterface
{

    /**
     * @param int|User $user
     * @return Collection
     */
    public function getAllAwardsByUser($user):Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function getAllAwardByOrganization($organization):Collection;

    /**
     * @param int|Department $department
     * @return Collection
     */
    public function getAllAwardbyDepartment($department):Collection;


}