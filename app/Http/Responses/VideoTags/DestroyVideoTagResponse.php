<?php

namespace App\Http\Responses\VideoTags;

use Illuminate\Contracts\Support\Responsable;

class DestroyVideoTagResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This tag has been removed from the video.'], 200);
    }
}
