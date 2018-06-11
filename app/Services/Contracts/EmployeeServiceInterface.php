<?php

namespace App\Services\Contracts;

use App\Models\Employee;

interface EmployeeServiceInterface
{
    /**
     * @param $data
     * @return Employee
     */
    public function addEmployee($data): Employee;

    /**
     * @param int|Employee $employee
     */
    public function archiveEmployee($employee): void;

    /**
     * @param int|Employee $employee
     */
    public function restoreEmployee($employee): void;

    /**
     * @param int|Employee $employee
     */
    public function removeEmployee($employee): void;

    /**
     * @param int|Employee $employee
     */
    public function activateSubscription($employee): void;

    /**
     * @param int|Employee $employee
     */
    public function cancelSubscription($employee): void;
}