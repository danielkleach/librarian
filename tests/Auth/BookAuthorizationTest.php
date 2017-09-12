<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $data = ['name' => 'Book Name'];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/books", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $book = factory(Book::class)->states(['withCategory'])->create();

        $data = ['name' => 'New Book Name'];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/books/{$book->id}", $data);

        $response->assertStatus(401);
    }

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $book = factory(Book::class)->states(['withCategory'])->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/books/{$book->id}");

        $response->assertStatus(401);
    }
}
