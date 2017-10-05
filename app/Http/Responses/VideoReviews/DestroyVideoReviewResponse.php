<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class DestroyVideoReviewResponse implements Responsable
{
    protected $videoReview;

    public function __construct($videoReview)
    {
        $this->videoReview = $videoReview;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This review has been deleted.'], 200);
    }
}
