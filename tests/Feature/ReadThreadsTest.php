<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;


    public function setUp() {
        parent::setUp();
        
        $this->thread = factory('Happy\ThreadMan\Thread')->create();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_browse_thread()
    {
        $this->get('/threads')
                ->assertStatus(200);
        // $response->assertSee($thread->title);
    }

    public function test_a_user_access_thread_detail(){
        
        $this->get('/threads/'.$this->thread->id)
                ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_that_associated_with_a_thread(){
        /**
         * Given we have a thread (1)
         * And the thread includes replies (2)
         * When we visit a thread page (3)
         * Then we should see the replies (4)
         */

         /*2*/
         $reply = factory('Happy\ThreadMan\Reply')->create(['thread_id' => $this->thread->id]);

         /**3 */
        $this->get('/threads/'. $this->thread->id)
                ->assertSee($reply->body);
    }
}
