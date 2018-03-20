<?php
namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

trait Favoritable 
{

    /**
     * Favorite the current reply.
     *
     * @return Model
     */
    public function favorite()
    {
        $attributes = [
            'user_id'           => auth()->id(),
        ];

        if (! $this->favorites()->where($attributes)->exists()){
            $this->favorites()->create($attributes);
        }
    }

    /** Processing Unfavorite */
    public function unfavorite()
    {
        $attributes = [
            'user_id'           => auth()->id(),
        ];

        $this->favorites()->where($attributes)->delete();
    }

    /**
     * Determine if the current reply has been favorited.
     *
     * @return boolean
     */
    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     *  get the isFavorite with $appends = ['isFavorited']
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * Get the number of favorites for the reply.
     * we can easily call it by shortly command using $appends = ['favoriteCount']
     * @return integer
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /**
     * Set relationship to table that have related
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}