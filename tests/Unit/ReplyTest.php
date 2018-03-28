<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;
    
    public $reply;
    
    public function setUp() {
        parent::setUp();
        
        $this->reply = factory(self::ReplyTbl)->create();
    }

    public function test_it_has_an_owner(){
        $this->assertInstanceOf('App\User', $this->reply->owner);
    }

    public function test_it_knows_if_it_just_was_published()
    {
        $reply = create(self::ReplyTbl);

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    public function test_it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create(self::ReplyTbl, [
            'body' => '@JanDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JanDoe', 'JohnDoe'], $reply->mentionedUsers());
    }
}
