<?php
namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

trait UserThreadMan{
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visit.%s", auth()->id(), $thread->id);
    }

    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
             \Carbon\Carbon::now()
        );
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? 'storage/'. $avatar : 'img/default.jpg');
    }

    public function confirm()
    {
        $this->confirmed = true;

        $this->save();
    }
}