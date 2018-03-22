<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_thread_can_subscribe_to_a_thread()
    {
        $this->signIn();

        $thread = create('Happy\ThreadMan\Thread');

        //And the user subscribes to the thread
        $this->post($thread->path() . '/subscriptions');

        //Then, each time a new reply is left
        // $this->assertCount(1, $thread->subscriptions);
        $thread->addReply([
            'user_id'   => auth()->id(),
            'body'      => 'some reply here'
        ]);

        // A notification should be prepared for the user
        // $this->assertCount(1, auth()->user()->notifications);
    }

    public function test_it_knows_if_the_authenticated_user_is_subsribed_to_it()
    {
        $this->signIn();

        $thread = create('Happy\ThreadMan\Thread');

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    public function test_a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        $thread = create(self::ThreadTbl);

        $thread->subscribe();

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->subscriptions);
    }
}
