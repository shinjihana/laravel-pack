<?php

use Faker\Generator as Faker;

$factory->define(Happy\ThreadMan\Thread::class, function (Faker $faker) {
    return [
        'user_id'   => function(){
            return factory('App\User')->create()->id;
        },
        'title'     => $faker->title,
        'body'      => $faker->paragraph,
    ];
});

$factory->define(Happy\ThreadMan\Reply::class, function (Faker $faker){
    return [
        'user_id'   => function(){
            return factory('App\User')->create()->id;
        },
        'thread_id'   => function(){
            return factory('Happy\ThreadMan\Thread')->create()->id;
        },
        'body'      => $faker->paragraph,
    ];
});
