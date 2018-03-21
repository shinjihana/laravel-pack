<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;


    public function setUp() {
        parent::setUp();
        
        $this->thread = factory(self::ThreadTbl)->create();
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
        
        $this->get($this->thread->path())
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
         $reply = factory(self::ReplyTbl)->create(['thread_id' => $this->thread->id]);

         /**3 */
        // $this->get($this->thread->path())
        //         ->assertSee($reply->body);
    }

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(self::ChannelTbl);

        $threadInChannel = create(self::ThreadTbl, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(self::ThreadTbl);

        $this->get('/threads/'. $channel->slug)
                ->assertSee($threadInChannel->title);
    }

    public function test_a_user_can_filter_thread_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'hoa']));

        $threadByJohn = create(self::ThreadTbl, ['user_id' => auth()->id()]);

        $threadNotByJohn = create(self::ThreadTbl);

        $this->get('threads?by=hoa')
                ->assertSee($threadByJohn->title);
    }

    public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create(self::ThreadTbl);

        create(self::ReplyTbl, ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path(). '/replies')->json();

        $this->assertCount(1, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
}
