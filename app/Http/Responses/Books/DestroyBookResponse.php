<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class DestroyBookResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This book has been deleted.'], 204);
    }
}
