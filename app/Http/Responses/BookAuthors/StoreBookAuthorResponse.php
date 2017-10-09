<?php

namespace App\Http\Responses\BookAuthors;

use Illuminate\Contracts\Support\Responsable;

class StoreBookAuthorResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This author has been added to the book.'], 201);
    }
}
