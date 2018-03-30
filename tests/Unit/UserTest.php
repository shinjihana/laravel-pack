<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('App\User');

        $reply = create(self::ReplyTbl, [
            'user_id' => $user->id
        ]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    public function test_a_user_can_determine_their_avartar_path()
    {
        $user = create('App\User');

        $this->assertEquals( asset('img/default.jpg'), $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals(asset('storage/avatars/me.jpg'), $user->avatar_path);

    }
}
