<?php

namespace Happy\ThreadMan\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Happy\ThreadMan\Events\ThreadReceiveNewReply;

class NotifySubscribers
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
     * @param  ThreadReceiveNewReply  $event
     * @return void
     */
    public function handle(ThreadReceiveNewReply $event)
    {
        $thread = $event->reply->thread;

        $thread->subscriptions
                ->where('user_id', '!=', $event->reply->user_id)
                ->each
                ->notify($event->reply);
    }
}
