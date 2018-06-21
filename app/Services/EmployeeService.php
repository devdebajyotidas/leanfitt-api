<?php

namespace App\Services;

use App\Models\Employee;
use App\Services\Contracts\EmployeeServiceInterface;
use App\Repositories\EmployeeRepository;

class EmployeeService implements EmployeeServiceInterface
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function addEmployee($data): Employee
    {
        // TODO: Implement addEmployee() method.
    }

    public function archiveEmployee($employee): void
    {
        // TODO: Implement archiveEmployee() method.
    }
    public function restoreEmployee($employee): void
    {
        // TODO: Implement restoreEmployee() method.
    }

    public function removeEmployee($employee): void
    {
        // TODO: Implement removeEmployee() method.
    }

    public function activateSubscription($employee): void
    {
        // TODO: Implement activateSubscription() method.
    }

    public function cancelSubscription($employee): void
    {
        // TODO: Implement cancelSubscription() method.
    }
}