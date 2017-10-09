<?php

namespace App\Http\Responses\BookAuthors;

use Illuminate\Contracts\Support\Responsable;

class DestroyBookAuthorResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This author has been removed from the book.'], 200);
    }
}
