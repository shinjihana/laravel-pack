<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;
    
    public $reply;
    
    public function setUp() {
        parent::setUp();
        
        $this->reply = factory('Happy\ThreadMan\Reply')->create();
    }

    public function test_it_has_an_owner(){
        $this->assertInstanceOf('App\User', $this->reply->owner);
    }

}
