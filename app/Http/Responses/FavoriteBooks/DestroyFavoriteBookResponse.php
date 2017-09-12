<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class DestroyFavoriteBookResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This favorite has been deleted.'], 200);
    }
}
