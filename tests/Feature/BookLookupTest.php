<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Traits\MockABookLookup;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookLookupTest extends TestCase
{
    use MockABookLookup, DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointCreatesABookByISBNInTheDatabase()
    {
        $this->mockBookLookup();

        $user = factory(User::class)->states(['admin'])->create();

        $data = [
            'isbn' => 'abcde12345'
        ];

        $response = $this->actingAs($user)->postJson("/books/lookup", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', [
            'title' => 'New test title',
            'description' => 'New test description.',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
        ]);
    }
}
