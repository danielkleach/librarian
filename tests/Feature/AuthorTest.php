<?php

namespace Tests\Feature;

use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedAuthor()
    {
        $author = factory(Author::class)->create();

        $response = $this->getJson("/authors/{$author->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $author->id,
            'name' => $author->name
        ]);
    }

    public function testStoreEndpointCreatesAAuthorInTheDatabase()
    {
        $data = [
            'name' => 'Author Name'
        ];

        $response = $this->postJson("/authors", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('authors', $data);
    }

    public function testUpdateEndpointUpdatesAnAuthorInTheDatabase()
    {
        $author = factory(Author::class)->create();

        $data = [
            'name' => 'New Author Name'
        ];

        $response = $this->patchJson("/authors/{$author->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', $data);
    }

    public function testDestroyEndpointRemovesAAuthor()
    {
        $author = factory(Author::class)->create();

        $response = $this->deleteJson("/authors/{$author->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('authors', ['id' => $author->id, 'deleted_at' => null]);
    }
}
