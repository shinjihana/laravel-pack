<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

use App\User;

use Happy\ThreadMan\Notifications\ThreadWasUpdated;
use Happy\ThreadMan\Events\ThreadReceiveNewReply;

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

        static::created(function($thread) {
            $thread->update(['slug' => $thread->title]);
        });
    }

    public function path(){
        return "/threads/{$this->channel->slug}/{$this->slug}";
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
        // $this->notifySubscribers($reply);
        
        event(new ThreadReceiveNewReply($reply));

        return $reply;
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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }

    public function lock()
    {
        $this->update(['locked' => true]);
    }
}
