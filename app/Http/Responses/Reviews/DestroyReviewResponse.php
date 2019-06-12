<?php

namespace App\Http\Responses\Reviews;

use Illuminate\Contracts\Support\Responsable;

class DestroyReviewResponse implements Responsable
{
    protected $review;

    public function __construct($review)
    {
        $this->review = $review;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This review has been deleted.'], 200);
    }
}
