<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class IndexCategoryResponse implements Responsable
{
    protected $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformCategories());
    }

    protected function transformCategories()
    {
        return $this->categories->map(function ($category) {
            return [
                'id' => (int) $category->id,
                'name' => $category->name,
                'book_count' => $category->getBookCount()
            ];
        });
    }
}
