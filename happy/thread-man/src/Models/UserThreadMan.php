<?php
namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

trait UserThreadMan{
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }
}