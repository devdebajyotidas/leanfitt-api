<?php

namespace App\Services\Contracts;


interface UserServiceInterface
{
    public function signup($request);

    public function accounts($user_id);

    public function profile($user_id);

    public function update($request,$user_id);

    public function delete($user_id);

    public function joinEmployee($request);
}