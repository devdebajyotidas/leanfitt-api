<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface
{

    public function getAllDepartments():Collection;

}