<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateForum extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    public function setUp(){
        parent::setUp();

        $this->thread = factory('Happy\ThreadMan\Thread')->create();
    }
    function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        //Give we have a authenticated user
        $user = factory('App\User')->create();
        $this->be($user); 
        //can be write like as $this->be($user = factory('App\User')->create();
        //And an Existing thread 
        $thread = factory('Happy\ThreadMan\Thread')->create(['user_id' => $user->id]);
        //When the user adds a rely to thread
        $reply = factory('Happy\ThreadMan\Reply')->create(['thread_id' => $thread->id, 'user_id' => $thread->user_id]);

        //check response return 200 if saving data is success
        $response =  $this->post($thread->path().'/replies', ['reply' => $reply->toArray(), '_token' => csrf_token()]);
        
        $this->assertDatabaseHas('replies', [
            'user_id' => $thread->user_id
        ]);
        $this->assertEquals(302, $response->getStatusCode());
        
        //Then their reply shoud be visible on the page
        $this->get($thread->path())
             ->assertSee($reply->body);
    }

    function test_unauthenticated_users_may_not_add_replies(){
        
        $reply = factory('Happy\ThreadMan\Reply')->create(['thread_id' => $this->thread->id]);

        $response =  $this->post($this->thread->path().'/replies', ['reply' => $reply->toArray(), '_token' => csrf_token()]);
        
        //302 -> have a redirect
        $this->assertEquals(302, $response->getStatusCode());
    }
}
