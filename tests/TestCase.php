<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const ThreadTbl = 'Happy\ThreadMan\Thread';
    const ReplyTbl = 'Happy\ThreadMan\Reply';
    const ChannelTbl = 'Happy\ThreadMan\Channel';
    
    public function signIn($user = null){
        $user = $user ?: create('App\User');

        $this->actingAs($user);

        return $this;
    }
}
