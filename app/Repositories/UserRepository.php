<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model()
    {
        return new User();
    }


    public function profile($user){
        $query=$this->model()->with(['employee.department','admin.organizationAdmin.organization'])->withCount('quiz')->withCount('award')->withCount('assignee')->where('id',$user)->first();
        return $query;
    }
}