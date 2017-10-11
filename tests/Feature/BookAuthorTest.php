<?php

namespace Tests\Feature;

use App\Book;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookAuthorTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointAddsAnAuthorToABook()
    {
        $author = factory(Author::class)->create();
        $book = factory(Book::class)->states(['withCategory'])->create();

        $data = [
            'author_id' => $author->id
        ];

        $response = $this->postJson("/books/{$book->id}/authors", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('book_authors', [
            'book_id' => $book->id,
            'author_id' => $author->id
        ]);
    }

    public function testDestroyEndpointRemovesAnAuthorFromABook()
    {
        $author = factory(Author::class)->create();
        $book = factory(Book::class)->states(['withCategory'])->create();
        $book->authors()->attach($author->id);

        $response = $this->deleteJson("/books/{$book->id}/authors/{$author->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('book_authors', [
            'book_id' => $book->id, 'author_id' => $author->id
        ]);
    }
}
