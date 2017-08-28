<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class UpdateUserReviewResponse implements Responsable
{
    protected $userReview;

    public function __construct($userReview)
    {
        $this->userReview = $userReview;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformUserReview());
    }

    protected function transformUserReview()
    {
        return [
            'id' => (int) $this->userReview->id,
            'user_id' => (int) $this->userReview->user_id,
            'book_id' => (int) $this->userReview->book_id,
            'rating' => $this->userReview->rating,
            'comments' => $this->userReview->comments
        ];
    }
}
