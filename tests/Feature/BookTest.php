<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedBook()
    {
        $book = factory(Book::class)->create();

        $response = $this->get("/api/books/{$book->id}");

        $response->assertJsonFragment($book);
    }

    public function testStoreEndpointCreatesABookInTheDatabase()
    {
        $data = [
            'category_id' => 1,
            'author_id' => 1,
            'title' => 'Test title',
            'description' => 'Test description.',
            'cover_image' => 'http://lorempixel.com/300/300',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
            'owner' => 'Daniel Leach',
            'total_copies' => 2,
            'available_copies' => 2
        ];

        $response = $this->postJson("/api/books", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $data);
    }

    public function testUpdateEndpointUpdatesAPostInTheDatabase()
    {
        $book = factory(Book::class)->create();

        $data = [
            'category_id' => 1,
            'author_id' => 1,
            'title' => 'New test title',
            'description' => 'New test description.',
            'cover_image' => 'http://lorempixel.com/300/300',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
            'owner' => 'Daniel Leach',
            'total_copies' => 2,
            'available_copies' => 2
        ];

        $response = $this->patchJson("/api/books/{$book->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $data);
    }

    public function testDestroyEndpointRemovesABook()
    {
        $book = factory(Book::class)->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id, 'deleted_at' => null]);
    }
}
