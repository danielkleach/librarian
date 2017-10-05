<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class DestroyBookReviewResponse implements Responsable
{
    protected $bookReview;

    public function __construct($bookReview)
    {
        $this->bookReview = $bookReview;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This review has been deleted.'], 200);
    }
}
