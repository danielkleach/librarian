<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class IndexUserReviewResponse implements Responsable
{
    protected $userReviews;

    public function __construct($userReviews)
    {
        $this->userReviews = $userReviews;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformUserReviews());
    }

    protected function transformUserReviews()
    {
        return $this->userReviews->map(function ($userReview) {
            return [
                'id' => (int) $userReview->id,
                'user_id' => (int) $userReview->user_id,
                'book_id' => (int) $userReview->book_id,
                'rating' => $userReview->rating,
                'comments' => $userReview->comments
            ];
        });
    }
}
