<?php

namespace App\Http\Responses\BookTags;

use Illuminate\Contracts\Support\Responsable;

class DestroyBookTagResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This tag has been removed from the book.'], 200);
    }
}
