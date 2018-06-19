<?php

namespace App\Repositories\Contracts;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllEmployees(): Collection;

    /**
     * @return Collection
     */
    public function getActiveEmployees(): Collection;

    /**
     * @return Collection
     */
    public function getArchivedEmployees(): Collection;

    /**
     * @param int|Department $department
     * @return Collection
     */
    public function getEmployeesByDepartment($department): Collection;

    /**
     * @param int|Department $department
     * @return Collection
     */
    public function getActiveEmployeesByDepartment($department): Collection;

    /**
     * @param int|Department $department
     * @return Collection
     */
    public function getArchivedEmployeesByDepartment($department): Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function getEmployeesByOrganization($organization): Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function getActiveEmployeesByOrganization($organization): Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function getArchivedEmployeesByOrganization($organization): Collection;

    /**
     * @param int|Employee $employee
     * @return bool
     */
    public function isArchived($employee): bool;

    /**
     * @param int|Employee $employee
     * @return bool
     */
    public function hasSubscription($employee): bool;

    public function changeDepartment($employee,$department);
}