<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class UpdateCategoryResponse implements Responsable
{
    protected $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformCategory());
    }

    protected function transformCategory()
    {
        return [
            'id' => (int) $this->category->id,
            'name' => $this->category->name
        ];
    }
}
