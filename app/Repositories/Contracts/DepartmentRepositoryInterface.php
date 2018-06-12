<?php

namespace App\Repositories\Contracts;

use App\Models\Organization;
use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllDepartments():Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function getAllDepartmentsByOrganization($organization):Collection;
}