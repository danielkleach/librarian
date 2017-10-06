<?php

namespace Tests\Feature;

use App\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoriteTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testDestroyEndpointRemovesAFavorite()
    {
        $favorite = factory(Favorite::class)->states(['withUser'])->create();

        $response = $this->deleteJson("/favorites/{$favorite->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorites', ['id' => $favorite->id, 'deleted_at' => null]);
    }
}
