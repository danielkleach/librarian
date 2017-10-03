<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use App\Rental;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookCheckinTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointChecksInARentalInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->create();

        $rental = factory(Rental::class)->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'return_date' => null
        ]);

        $response = $this->actingAs($user)->postJson("/books/{$rental->book_id}/checkin/{$rental->id}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'return_date' => Carbon::now()->toDateTimeString()
        ]);
    }
}
