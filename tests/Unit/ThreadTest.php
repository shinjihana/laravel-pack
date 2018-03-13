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

        $this->thread =  factory('Happy\ThreadMan\Thread')->create();
    }
    
    public function test_a_thread_has_a_creator(){
        $thread = factory('Happy\ThreadMan\Thread')->create();

        $this->assertInstanceOf('App\User', $thread->creator);
    }

    public function test_a_thread_can_add_a_reply(){
        $this->thread->addReply([
            'body'      => 'Foobar',
            'user_id'   => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
