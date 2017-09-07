<?php

namespace App\Http\Controllers;

use App\UserReview;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserReviewRequest;

class UserReviewController extends Controller
{
    protected $userReviewModel;

    public function __construct(UserReview $userReviewModel)
    {
        $this->userReviewModel = $userReviewModel;
    }

    public function store(UserReviewRequest $request, $bookId)
    {
        $userReview = $this->userReviewModel->create([
            'user_id' => Auth::user()->id,
            'book_id' => $bookId,
            'rating' => $request->rating,
            'comments' => $request->comments
        ]);

        return new StoreUserReviewResponse($userReview);
    }

    public function update(UserReviewRequest $request, $userReviewId)
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
