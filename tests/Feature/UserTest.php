<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Http\Resources\User as UserResource;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedUser()
    {
        $user = factory(User::class)->create();

        $response = $this->getJson("/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'created_at' => $user->created_at->format('F j, Y'),
            'updated_at' => $user->updated_at->format('F j, Y')
        ]);
    }

    public function testStoreEndpointCreatesAUserInTheDatabase()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'password' => 'Tester12'
        ];

        $response = $this->postJson("/users", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $data);
    }

    public function testUpdateEndpointUpdatesAUserInTheDatabase()
    {
        $user = factory(User::class)->create();

        $data = [
            'first_name' => 'New',
            'last_name' => 'Tester',
            'email' => 'tester@tester.com'
        ];

        $response = $this->patchJson("/users/{$user->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $data);
    }
}
