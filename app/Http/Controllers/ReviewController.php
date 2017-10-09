<?php

namespace App\Http\Controllers;

use App\Review;
use App\Http\Responses\Reviews\DestroyReviewResponse;

class ReviewController extends Controller
{
    protected $reviewModel;

    /**
     * ReviewController constructor.
     *
     * @param Review $reviewModel
     */
    public function __construct(Review $reviewModel)
    {
        $this->reviewModel = $reviewModel;
    }

    public function destroy($reviewId)
    {
        $review = $this->reviewModel->findOrFail($reviewId);

        $review->delete();

        return new DestroyReviewResponse($review);
    }
}
