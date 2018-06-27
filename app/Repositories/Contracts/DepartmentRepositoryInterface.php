<?php

namespace App\Repositories\Contracts;

use App\Models\Organization;
use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface
{
    public function getDepartments();
}