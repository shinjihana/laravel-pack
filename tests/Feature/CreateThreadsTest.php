<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    function test_guest_may_not_create_thread()
    {
        /* Given we have a signed in User */
        $this->actingAs(factory('App\User')->create());

        /* When we hit the endpoint to create a new thread */
        $thread = factory('Happy\ThreadMan\Thread')->make();
        $this->post('/threads', $thread->toArray());


    }

    public function test_an_authenticated_user_can_create_new_forum_threads()
    {
        /* Given we have a signed in User */
        // $this->actingAs(create('App\User'));
        $this->signIn();

        /* When we hit the endpoint to create a new thread */
        $thread = make('Happy\ThreadMan\Thread');
        $this->post('/threads', $thread->toArray());

        /* Then, when we visit the thread page:*/
        $response = $this->get($thread->path());
        
        /* we should see the new thread:*/
        $response->assertSee($thread->title)
                ->assertSee($thread->body);
    }
}