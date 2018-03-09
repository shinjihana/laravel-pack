## Introduction
Managing Post Thread and Reply

1. Thread
2. Reply
3. User

A. Thread is created by a user
B. A reply belongs to a thread, and belongs to a user

##create data for testing
#step 1
$factory->define(Happy\ThreadMan\Thread::class, function (Faker $faker) {
    return [
        'user_id'   => function(){
            return factory('App\User')->create()->id;
        },
        'title'     => $faker->title,
        'body'      => $faker->paragraph,
    ];
});

#step 2 : 
way 1:
factory('Happy\ThreadMan\Thread', 20)->create();

way 2 : 
$threads = factory('Happy\ThreadMan\Thread', 20)->create();

$threads->each(function ($thread){
    factory('Happy\ThreadMan\Reply', 2)->create(['thread_id' => $thread->id]);
});