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
     * Get the number of favorites for the reply.
     *
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