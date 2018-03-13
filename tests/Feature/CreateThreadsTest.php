<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    const ThreadTbl = 'Happy\ThreadMan\Thread';

    function test_guest_may_not_create_thread()
    {
        /* Given we have a signed in User */
        // $this->actingAs(factory('App\User')->create());

        /* When we hit the endpoint to create a new thread */
        $thread = factory('Happy\ThreadMan\Thread')->make();
        $this->post('/threads', $thread->toArray())
                ->assertRedirect('/login');
    }

    function test_guest_cannot_see_the_create_thread_page()
    {
       $this->get('/threads/create')
                ->assertRedirect('/login'); 
    }

    public function test_an_authenticated_user_can_create_new_forum_threads()
    {
        /* Given we have a signed in User */
        // $this->actingAs(create('App\User'));
        $this->signIn();

        /* When we hit the endpoint to create a new thread */
        $thread = create('Happy\ThreadMan\Thread');
        $response = $this->post('/threads', $thread->toArray());

        /* Then, when we visit the thread page:*/
        $response = $this->get($response->headers->get('Location'));

        /* we should see the new thread:*/
        $response->assertSee($thread->title)
                ->assertSee($thread->body);
    }

    // function test_a_thread_requires_a_title()
    // {
    //     $this->signIn();

    //     $thread = make(self::ThreadTbl, ['title' => null]);

    //     $this->post('/threads', $thread->toArray())
    //             ->assertSessionHasErrors('title');
    // }

    function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
                ->assertSessionHasErrors('title');
    }

    function test_a_thread_requires_a_channel()
    {
        $this->publishThread(['channel_id' => null])
                ->assertSessionHasErrors('channel_id');
    }


    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make(self::ThreadTbl, $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
