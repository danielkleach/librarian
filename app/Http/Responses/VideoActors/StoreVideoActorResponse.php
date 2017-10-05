<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class StoreVideoActorResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This actor has been added to the video.'], 201);
    }
}
