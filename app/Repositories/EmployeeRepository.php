<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Support\Collection;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return new Employee();
    }

    public function getAllEmployees(): Collection
    {
        // TODO: Implement getAllEmployees() method.
    }

    public function getActiveEmployees(): Collection
    {
        // TODO: Implement getActiveEmployees() method.
    }

    public function getArchivedEmployees(): Collection
    {
        // TODO: Implement getArchivedEmployees() method.
    }

    public function getEmployeesByDepartment($department): Collection
    {
        // TODO: Implement getEmployeesByDepartment() method.
    }

    public function getActiveEmployeesByDepartment($department): Collection
    {
        // TODO: Implement getActiveEmployeesByDepartment() method.
    }

    public function getArchivedEmployeesByDepartment($department): Collection
    {
        // TODO: Implement getArchivedEmployeesByDepartment() method.
    }

    public function getEmployeesByOrganization($organization): Collection
    {
        // TODO: Implement getEmployeesByOrganization() method.
    }

    public function getActiveEmployeesByOrganization($organization): Collection
    {
        // TODO: Implement getActiveEmployeesByOrganization() method.
    }

    public function getArchivedEmployeesByOrganization($organization): Collection
    {
        // TODO: Implement getArchivedEmployeesByOrganization() method.
    }

    public function isArchived($employee): bool
    {
        // TODO: Implement isArchived() method.
    }

    public function hasSubscription($employee): bool
    {
        // TODO: Implement hasSubscription() method.
    }
}