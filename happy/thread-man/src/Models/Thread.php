<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

use App\User;

use Happy\ThreadMan\Notifications\ThreadWasUpdated;
use Happy\ThreadMan\Events\ThreadHasNewReply;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];
    
    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('replyCount', function($builder){
        //     $builder->withCount('replies');
        // });

        static::deleting(function ($thread){
            $thread->replies->each->delete();
            // $thread->replies->each(function($reply){
            //     $reply->delete();
            // });
        });
    }

    public function path(){
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies(){
        return $this->hasMany(Reply::class)
                    ->withCount('favorites')
                    ->with('owner');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Add a reply to thread
     * 
     * @param : Reply
     */
    public function addReply($reply){

        $reply = $this->replies()->create($reply);

        /**
         * way 1 :Using Event
         */
        // event(new ThreadHasNewReply($this, $reply));
        /**
         * way 1 :Using Event
         */

        /**way 2 - call currently */
        $this->notifySubscribers($reply);
        
        return $reply;
    }

    /**notify to subscriber */
    public function notifySubscribers($reply)
    {
        $this->subscriptions
             ->where('user_id', '!=', $reply->user_id)
             ->each
             ->notify($reply);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id'   => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
              ->where('user_id', $userId ?: auth()->id())
              ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
                    ->where('user_id', auth()->id())
                    ->exists();
    }

    /**
     * build thread has updated or not
     * 
     */
    public function hasUpdatesFor($user = null)
    {
        // Look in the cache for the proper key.

        //Compare that carbon instance with the $thread->update_at

        /**========== Way 1 ===== call currently */
        // $key = sprintf("users.%s.visit.%s", auth()->id(), $this->id);
        /**========== Way 1 ===== call currently */

        /**========== Way 2 ===== call by user  */
        $user = $user ? : auth()->user();

        $key = $user->visitedThreadCacheKey($this);
        /**========== Way 2 ===== call by user */

        return $this->updated_at > cache($key);
    }
}
