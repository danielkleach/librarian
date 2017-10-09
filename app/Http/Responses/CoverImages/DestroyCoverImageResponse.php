<?php

namespace App\Http\Responses\CoverImages;

use Illuminate\Contracts\Support\Responsable;

class DestroyCoverImageResponse implements Responsable
{
    protected $coverImage;

    public function __construct($coverImage)
    {
        $this->coverImage = $coverImage;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'The cover image has been deleted.'], 200);
    }
}
