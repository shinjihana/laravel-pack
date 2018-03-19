<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function favorited()
    {
        return $this->morphTo();
    }
}
