<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexRejectsAnUnauthorizedUser()
    {
        factory(User::class, 5)->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->getJson("/users");

        $response->assertStatus(401);
    }

    public function testShowRejectsAnUnauthorizedUser()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->getJson("/users/{$user->id}");

        $response->assertStatus(401);
    }

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'password' => 'Tester12'
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/users", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $user = factory(User::class)->create();

        $data = ['first_name' => 'New'];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/users/{$user->id}", $data);

        $response->assertStatus(401);
    }

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/users/{$user->id}");

        $response->assertStatus(401);
    }
}
