<?php

namespace App\Repositories\Contracts;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface
{
    public function getEmployees();

    public function showEmployee($employee_id);

    public function checkEmployee($user);
}