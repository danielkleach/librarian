<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookCheckoutAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->states(['withCategory'])->create();

        $data = [
            'user_id' => (int) $user->id
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/books/{$book->id}/checkout", $data);

        $response->assertStatus(401);
    }
}
