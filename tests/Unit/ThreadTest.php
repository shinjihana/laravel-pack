<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
