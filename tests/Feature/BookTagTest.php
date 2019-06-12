<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTagTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointAddsATagToABook()
    {
        $book = factory(Book::class)->states(['withCategory'])->create();

        $data = [
            'tag' => 'php'
        ];

        $response = $this->postJson("/books/{$book->id}/tags", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $book->id,
            'taggable_type' => 'App\Book'
        ]);
    }

    public function testDestroyEndpointRemovesATagFromABook()
    {
        $tag = 'php';

        $book = factory(Book::class)->states(['withCategory'])->create();
        $book->attachTag($tag);

        $response = $this->deleteJson("/books/{$book->id}/tags/{$tag}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('taggables', [
            'taggable_id' => $book->id,
            'taggable_type' => 'App/Book'
        ]);
    }
}
