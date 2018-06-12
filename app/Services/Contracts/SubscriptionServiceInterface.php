<?php

namespace App\Services\Contracts;

use App\Models\Employee;
use App\Models\Subscription;
use App\Models\User;

interface SubscriptionServiceInterface
{
    /**
     * @param $data
     * @return bool
     */
    public function newSubscription($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function updateSubscription($data):bool;

    /**
     * @param int|Employee $employee
     * @param int|Subscription $subscription
     * @return bool
     */
    public function cancelSunscription($employee,$subscription):bool;

    /**
     * @param int|User $user
     * @param int|Subscription $subscription
     * @return bool
     */
    public function refund($user,$subscription):bool;
}