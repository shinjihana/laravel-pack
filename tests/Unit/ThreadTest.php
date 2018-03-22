<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    public function setUp(){
        parent::setUp();

        $this->thread =  factory(self::ThreadTbl)->create();
    }
    
    public function test_a_thread_has_a_creator(){
        $thread = factory(self::ThreadTbl)->create();

        $this->assertInstanceOf('App\User', $thread->creator);
    }

    public function test_a_thread_can_add_a_reply(){
        $this->thread->addReply([
            'body'      => 'Foobar',
            'user_id'   => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    function test_a_thread_belongs_to_a_chanel()
    {
        $thread = create(self::ThreadTbl);

        $this->assertInstanceOf(self::ChannelTbl, $thread->channel);
    }

    function test_a_thread_can_make_a_string_path()
    {
        $thread = create(self::ThreadTbl);
        
        // $this->assertEquals('/threads/'. $thread->channel->slug. '/'. $thread->id, $thread->path());
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    function test_a_user_can_filter_thread_by_popularity()
    {
        //Given we have three threads
        //With 2 replies, 3 replies, and 0 replies, respectively.
        $threadWithTwoReplies = create(self::ThreadTbl);
        create(self::ReplyTbl, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(self::ThreadTbl);
        create(self::ReplyTbl, ['thread_id' => $threadWithThreeReplies->id], 3);

        //When I filter all threads by popularity
        $response =  $this->getJson('threads?popular=1')->json();

        //Then they should be returned from most replies to least.
        // $response->assertSee($threadWithThreeReplies->title);
        // dd($response);
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }

    public function test_a_thread_can_be_subscribe()
    {
        // Given we have a thread
        $thread = create(self::ThreadTbl);
        
        // And a authenticated user
        // $this->signIn();

        // when the user subscribes to the thread
        $thread->subscribe($userId = 1);

        // Then we should be able to fetch all threads that users have subscribed to
        // $user->subscriptions(); //u can also call it such as below
        $this->assertEquals(
            1, 
            $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    public function test_a_thread_can_be_unsubscribed_from()
    {
        $thread = create(self::ThreadTbl);

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }
}
