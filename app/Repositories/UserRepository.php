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
        $result=$this->model()->with('admin')->where('id',$id)->first();
        return $result->admin->is_superadmin==0 ? false : true;
    }

    public function isEmployee($id): bool
    {
        $result=$this->model()->where('id',$id)->withCount('employee')->first();
        return $result->employee_count > 0 ? true : false;
    }
}