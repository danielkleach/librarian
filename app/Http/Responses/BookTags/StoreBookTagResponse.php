<?php

namespace App\Http\Responses\BookTags;

use Illuminate\Contracts\Support\Responsable;

class StoreBookTagResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This tag has been added to the book.'], 201);
    }
}
