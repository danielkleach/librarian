<?php

namespace Tests\Feature;

use App\Author;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $data = ['name' => 'Author Name'];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/authors", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $author = factory(Author::class)->create();

        $data = ['name' => 'New Author Name'];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/authors/{$author->id}", $data);

        $response->assertStatus(401);
    }

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $author = factory(Author::class)->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/authors/{$author->id}");

        $response->assertStatus(401);
    }
}
