<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

use App\User;
use Happy\ThreadMan\Thread;

use Happy\ThreadMan\Notifications\ThreadWasUpdated;

class ThreadSubscription extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Notify to Relevant user notifications
     */
    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
