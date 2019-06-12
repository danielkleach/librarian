<?php

namespace App\Http\Responses\VideoTags;

use Illuminate\Contracts\Support\Responsable;

class StoreVideoTagResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This tag has been added to the video.'], 201);
    }
}
