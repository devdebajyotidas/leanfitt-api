<?php

namespace App\Services\Contracts;


interface UserServiceInterface
{
    public function signup($request);

    public function invite($request);

    public function joinInvited($request,$token);

    public function updateProfile($request,$user_id);

    public function deactivateAccount($user_id);

    public function cancelSubscription($user_id);

    public function subscribe($request,$user_id);

    public function reactivateSubscription($user_id);

    public function profile($request,$user_id);

    public function employees($organization_id);

    public function changeDepartment($request,$user_id);

    public function archiveUser($user_id,$type);

    public function restoreUser($user_id,$type);

    public function removeUser($user_id,$type);

    public function analytic($user_id);

}