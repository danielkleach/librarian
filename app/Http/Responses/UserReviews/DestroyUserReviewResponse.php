<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class DestroyUserReviewResponse implements Responsable
{
    protected $userReview;

    public function __construct($userReview)
    {
        $this->userReview = $userReview;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This user review has been deleted.'], 200);
    }
}
