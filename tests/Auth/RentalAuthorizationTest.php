<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RentalAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $rental = factory(Rental::class)->states(['withUser', 'withBook'])->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/rentals/{$rental->id}");

        $response->assertStatus(401);
    }
}
