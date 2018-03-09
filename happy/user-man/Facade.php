<?php 
namespace Happy\UserMan;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return UserMan::class;
    }
}
