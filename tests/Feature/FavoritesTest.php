<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    function test_guest_cannot_favorite_anything()
    {
        //if I post to a 'favorite' endpoint
        $this->post('replies/1/favorites')
                ->assertRedirect('/login');
    }

    function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create(self::ReplyTbl);

        try {
            //if I post to a 'favorite' endpoint
            $this->post('/replies/'. $reply->id. '/favorites');

            $this->post('/replies/'. $reply->id. '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice');
        }

        //It should be recorded in the database
        $this->assertCount(1, $reply->favorites);
    }

    function test_an_authenticated_user_can_unfavorite_any_reply()
    {
        $this->signIn();

        $reply = create(self::ReplyTbl);

        try {
            //if I post to a 'favorite' endpoint
            $this->post('/replies/'. $reply->id. '/favorites');
            $this->assertCount(1, $reply->favorites);

            $this->delete('/replies/'. $reply->id. '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice');
        }

        //It should be recorded in the database
        $this->assertCount(0, $reply->fresh()->favorites);
    }
}
