<?php

namespace App\Providers;

use App\Providers\AddPostEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNotification
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
     * @param  \App\Providers\AddPostEvent  $event
     * @return void
     */
    public function handle(AddPostEvent $event)
    {
        Log::debug("Event Sent!".$event->post->name);
    }
}
