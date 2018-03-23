<?php

namespace Happy\ThreadMan\Listeners;

use Happy\ThreadMan\Events\ThreadHasNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NofifyThreadSubscribes
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
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        //preparing for notification for all subscribers
        $event->thread->notifySubscribers($event->reply);
    }
}
