<?php

namespace Tests\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function testRegisterEndpointRegistersANewUser()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'password' => 'Tester12'
        ];

        $expectedUserData = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
        ];

        $response = $this->postJson("/register", $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'created_at',
                'updated_at',
                'api_token',
            ]
        ]);
        $this->assertDatabaseHas('users', $expectedUserData);
    }
}
