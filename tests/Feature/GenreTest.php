<?php

namespace Tests\Feature;

use App\Genre;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GenreTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedGenre()
    {
        $genre = factory(Genre::class)->create();

        $response = $this->getJson("/genres/{$genre->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $genre->id,
            'name' => $genre->name
        ]);
    }

    public function testStoreEndpointCreatesAGenreInTheDatabase()
    {
        $data = [
            'name' => 'Genre Name'
        ];

        $response = $this->postJson("/genres", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('genres', $data);
    }

    public function testUpdateEndpointUpdatesAGenreInTheDatabase()
    {
        $genre = factory(Genre::class)->create();

        $data = [
            'name' => 'New Genre Name'
        ];

        $response = $this->patchJson("/genres/{$genre->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('genres', $data);
    }
}
