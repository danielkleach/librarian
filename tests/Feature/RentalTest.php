<?php

namespace Tests\Feature;

use App\Rental;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RentalTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testDestroyEndpointRemovesARental()
    {
        $rental = factory(Rental::class)->states(['withUser', 'withBook'])->create();

        $response = $this->deleteJson("/rentals/{$rental->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('rentals', ['id' => $rental->id, 'deleted_at' => null]);
    }
}
