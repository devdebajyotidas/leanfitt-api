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

    public function archiveUser($id,$type); //type=user/employee

    public function restoreUser($id,$type); //type=user/employee

    public function removeUser($id,$type); //type=user/employee

    public function analytic($user_id);

}