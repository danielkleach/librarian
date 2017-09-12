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

        $response = $this->getJson("/categories/{$category->id}");

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

        $response = $this->postJson("/categories", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', $data);
    }

    public function testUpdateEndpointUpdatesACategoryInTheDatabase()
    {
        $category = factory(Category::class)->create();

        $data = [
            'name' => 'New Category Name'
        ];

        $response = $this->patchJson("/categories/{$category->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', $data);
    }
}
