<?php

namespace Tests\Feature;

use App\User;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $data = ['name' => 'Category Name'];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/categories", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $category = factory(Category::class)->create();

        $data = ['name' => 'New Category Name'];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/categories/{$category->id}", $data);

        $response->assertStatus(401);
    }
}
