<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class StoreFavoriteBookResponse implements Responsable
{
    protected $favorite;

    public function __construct($favorite)
    {
        $this->favorite = $favorite;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformBook(), 201);
    }

    protected function transformBook()
    {
        return [
            'id' => (int) $this->favorite->id,
            'user_id' => (int) $this->favorite->user_id,
            'book_id' => (int) $this->favorite->book_id
        ];
    }
}
