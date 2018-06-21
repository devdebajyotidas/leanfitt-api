<?php

namespace App\Services;

use App\Repositories\DepartmentRepository;
use App\Services\Contracts\DepartmentServiceInterface;

class DepartmentService implements DepartmentServiceInterface
{

    protected $departmentRepository;
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository=$departmentRepository;
    }

    public function addDepartment($data): bool
    {
        // TODO: Implement addDepartment() method.
    }

    public function updateDepartment($data): bool
    {
        // TODO: Implement updateDepartment() method.
    }

    public function archiveDepartment($department): bool
    {
        // TODO: Implement archiveDepartment() method.
    }

    public function restoreDepartment($department): bool
    {
        // TODO: Implement restoreDepartment() method.
    }

    public function removeDepartment($department): bool
    {
        // TODO: Implement removeDepartment() method.
    }
}