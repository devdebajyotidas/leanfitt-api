<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return new User();
    }

    public function isAdmin($user): bool
    {
        // TODO: Implement isAdmin() method.
    }

    public function isSuperAdmin($user): bool
    {
        // TODO: Implement isSuperAdmin() method.
    }

    public function isEmployee($user): bool
    {
        // TODO: Implement isEmployee() method.
    }
}