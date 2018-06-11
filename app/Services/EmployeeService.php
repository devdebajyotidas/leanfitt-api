<?php

namespace App\Services;

use App\Services\Contracts\EmployeeServiceInterface;
use App\Repositories\EmployeeRepository;

class EmployeeService implements EmployeeServiceInterface
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }


}