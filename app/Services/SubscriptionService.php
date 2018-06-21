<?php

namespace App\Services;

use App\Services\Contracts\SubscriptionServiceInterface;

class SubscriptionService implements SubscriptionServiceInterface
{

    public function __construct()
    {
    }

    public function newSubscription($data): bool
    {
        // TODO: Implement newSubscription() method.
    }

    public function updateSubscription($data): bool
    {
        // TODO: Implement updateSubscription() method.
    }

    public function cancelSunscription($employee, $subscription): bool
    {
        // TODO: Implement cancelSunscription() method.
    }

    public function refund($user, $subscription): bool
    {
        // TODO: Implement refund() method.
    }
}