<?php

use Faker\Generator as Faker;

$factory->define(Happy\ThreadMan\Thread::class, function (Faker $faker) {
    return [
        'user_id'   => function(){
            return factory('App\User')->create()->id;
        },
        'channel_id'   => function(){
            return factory('Happy\ThreadMan\Channel')->create()->id;
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

$factory->define(Happy\ThreadMan\Channel::class, function (Faker $faker){
    $name = $faker->word;

    return [
        'name'   => $name,
        'slug'      => $name,
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function($faker){
    return [
        'id'                    => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type'                  => 'Happy\ThreadMan\Notifications\ThreadWasUpdated',
        'notifiable_id'         => function(){
            return auth()->id() ? : factory('App\User')->create()->id();
        },
        'notifiable_type'       => 'App\User',
        'data'                  => ['foo'   => 'bar'],
    ];
});
