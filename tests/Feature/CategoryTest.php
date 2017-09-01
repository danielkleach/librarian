<?php

namespace Tests\Feature;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedCategory()
    {
        $category = factory(Category::class)->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $category->id,
            'name' => $category->name
        ]);
    }

    public function testStoreEndpointCreatesACategoryInTheDatabase()
    {
        $data = [
            'name' => 'Category Name'
        ];

        $response = $this->postJson("/api/categories", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $data);
    }

    public function testUpdateEndpointUpdatesACategoryInTheDatabase()
    {
        $category = factory(Category::class)->create();

        $data = [
            'name' => 'New Category Name'
        ];

        $response = $this->patchJson("/api/categories/{$category->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $data);
    }

    public function testDestroyEndpointRemovesACategory()
    {
        $category = factory(Category::class)->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $category->id, 'deleted_at' => null]);
    }
}
