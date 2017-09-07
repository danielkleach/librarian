<?php

namespace Tests\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogoutTest extends TestCase
{
    use DatabaseTransactions;

    public function testLogoutEndpointLogsAUserOutAndRemovesTheirToken()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer {$token}"];

        $this->json('get', '/users', [], $headers)->assertStatus(200);
        $this->json('post', '/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }
}
