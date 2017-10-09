<?php

namespace App\Http\Responses\CoverImages;

use Illuminate\Contracts\Support\Responsable;

class StoreCoverImageResponse implements Responsable
{
    protected $coverImage;

    public function __construct($coverImage)
    {
        $this->coverImage = $coverImage;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformCoverImage(), 201);
    }

    protected function transformCoverImage()
    {
        return ['cover_image_url' => $this->coverImage->url()];
    }
}
