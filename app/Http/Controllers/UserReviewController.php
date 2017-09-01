<?php

namespace App\Http\Controllers;

use App\UserReview;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    protected $userReviewModel;

    public function __construct(UserReview $userReviewModel)
    {
        $this->userReviewModel = $userReviewModel;
    }

    public function store(Request $request, $bookId)
    {
        $userReview = $this->userReviewModel->create([
            'user_id' => $request->user_id,
            'book_id' => $bookId,
            'rating' => $request->rating,
            'comments' => $request->comments
        ]);

        return new StoreUserReviewResponse($userReview);
    }

    public function update(Request $request, $userReviewId)
    {
        $userReview = $this->userReviewModel->findOrFail($userReviewId);

        $userReview->update($request->all());

        return new UpdateUserReviewResponse($userReview);
    }

    public function destroy($userReviewId)
    {
        $userReview = $this->userReviewModel->findOrFail($userReviewId);

        $userReview->delete();

        return new DestroyUserReviewResponse($userReview);
    }
}
