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

    public function isAdmin($id): bool
    {
        $result=$this->model()->find($id)->admin()->count();
        return $result > 0 ? true : false;
    }

    public function isSuperAdmin($id): bool
    {
        $result=$this->model()->find($id)->admin()->where('is_superadmin',1)->count();
        return $result > 0 ? true : false;
    }

    public function isEmployee($id): bool
    {
        $result=$this->model()->find($id)->employee()->count();
        return $result > 0 ? true : false;
    }

    /*Add*/

    /*update*/ /*chnage password*/ /*change avatar*/

    /*archive*/

    /*restore*/

    /*remove*/

    /*verify->user find and then check*/
}