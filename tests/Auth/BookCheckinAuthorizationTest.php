<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookCheckinAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $rental = factory(Rental::class)->states(['withUser', 'withBook'])->create([
            'return_date' => null
        ]);

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/books/{$rental->book_id}/checkin/{$rental->id}");

        $response->assertStatus(401);
    }
}
