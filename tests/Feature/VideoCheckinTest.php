<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use App\Rental;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoCheckinTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointChecksInARentalInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $video = factory(Video::class)->create();

        $rental = factory(Rental::class)->create([
            'user_id' => $user->id,
            'rentable_id' => $video->id,
            'rentable_type' => get_class($video),
            'return_date' => null
        ]);

        $response = $this->actingAs($user)->postJson("/videos/{$rental->rentable_id}/checkin/{$rental->id}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'return_date' => Carbon::now()->toDateTimeString()
        ]);
    }
}
