<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function isSuperAdmin($user);

    public function isAdmin($user);

    public function isEmployee($user);
}