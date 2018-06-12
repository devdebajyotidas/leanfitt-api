<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Illuminate\Support\Collection;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{

    public function model(){
        return new Department();
    }

    public function getAllDepartmentsByOrganization($organization): Collection
    {
        // TODO: Implement getAllDepartmentsByOrganization() method.
    }
}