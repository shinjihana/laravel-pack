<?php

namespace Happy\ThreadMan\Listeners;

use Happy\ThreadMan\Events\ThreadReceiveNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

use Happy\ThreadMan\Notifications\YouWereMentioned;

class NotifyMentionedUsers
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
     * @param  ThreadReciveNewReply  $event
     * @return void
     */
    public function handle(ThreadReceiveNewReply $event)
    {
        //And then for each mentioned user, notify then.
        collect($event->reply->mentionedUsers())
            ->map(function($name) {
                return User::whereName($name)->first();
            })
            ->filter()
            ->each(function($user) use($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
