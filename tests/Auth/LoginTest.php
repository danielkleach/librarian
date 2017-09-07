<?php

namespace Tests\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginEndpointLogsInAUserWithCorrectCredentials()
    {
        $user = factory(User::class)->create();

        $data = [
            'email' => $user->email,
            'password' => 'Tester12'
        ];

        $response = $this->postJson("/login", $data);

        $response->assertStatus(200);
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
    }
}
