<?php

namespace App\Http\Controllers;

use App\Review;
use App\EntityFactory;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Review as ReviewResource;
use App\Http\Responses\Reviews\DestroyReviewResponse;

class ReviewController extends Controller
{
    protected $reviewModel, $entityFactory;

    /**
     * ReviewController constructor.
     *
     * @param Review $reviewModel
     * @param EntityFactory $entityFactory
     */
    public function __construct(Review $reviewModel, EntityFactory $entityFactory)
    {
        $this->reviewModel = $reviewModel;
        $this->entityFactory = $entityFactory;
    }

    public function store(ReviewRequest $request, $itemType, $itemId)
    {
        $entity = $this->entityFactory->translate($itemType);
        $item = $entity->find($itemId);

        $review = $this->reviewModel->createReview($request->all(), Auth::user()->id, $item);

        return new ReviewResource($review);
    }

    public function update(ReviewRequest $request, $reviewId)
    {
        $review = $this->reviewModel->findOrFail($reviewId);
        $this->authorize('update', $review);

        $review->update($request->all());

        return new ReviewResource($review);
    }

    public function destroy($reviewId)
    {
        $review = $this->reviewModel->findOrFail($reviewId);
        $this->authorize('destroy', $review);

        $review->delete();

        return new DestroyReviewResponse($review);
    }
}
