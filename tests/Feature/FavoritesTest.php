<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    // function test_guest_cannot_favorite_anything()
    // {
    //     //if I post to a 'favorite' endpoint
    //     $this->post('replies/1/favorites')
    //             ->assertRedirect('/login');
    //     //It should be recorded in the database
    //     // $this->assertCount(1, $reply->favorites);
    // }

    // function test_an_authenticated_user_can_favorite_any_reply()
    // {
    //     $reply = create(self::ReplyTbl);

    //     //if I post to a 'favorite' endpoint
    //     $this->post('replies/'. $reply->id. '/favorite');
    //     //It should be recorded in the database
    //     $this->assertCount(1, $reply->favorites);
    // }
}
