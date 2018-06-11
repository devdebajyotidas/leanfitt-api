<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param int|User $user
     * @return boolean
     */
    public function isSuperAdmin($user):bool;

    /**
     * @param int|User $user
     * @return bool
     */
    public function isAdmin($user):bool;

    /**
     * @param int|User $user
     * @return bool
     */
    public function isEmployee($user):bool;
}