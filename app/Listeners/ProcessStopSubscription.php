<?php

namespace App\Listeners;

use App\Events\StopSubscription;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessStopSubscription
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StopSubscription  $event
     * @return void
     */
    public function handle(StopSubscription $event)
    {
        //
    }
}
