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
                'user_name' => $userReview->user->first_name,
                'book_id' => (int) $userReview->book_id,
                'book_title' => $userReview->book->title,
                'rating' => $userReview->rating,
                'comments' => $userReview->comments
            ];
        });
    }
}
