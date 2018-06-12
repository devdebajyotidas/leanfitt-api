<?php

namespace App\Repositories\Contracts;

use App\Models\Organization;
use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface
{
    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function getAllDepartmentsByOrganization($organization):Collection;
}