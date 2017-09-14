<?php

namespace App\Http\Controllers;

use App\UserReview;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserReviewRequest;
use App\Http\Resources\UserReview as UserReviewResource;

class UserReviewController extends Controller
{
    protected $userReviewModel;

    public function __construct(UserReview $userReviewModel)
    {
        $this->userReviewModel = $userReviewModel;
    }

    public function show($userReviewId)
    {
        return new UserReviewResource($this->userReviewModel
            ->with(['user', 'book'])->findOrFail($userReviewId));
    }

    public function store(UserReviewRequest $request, $bookId)
    {
        return new UserReviewResource($this->userReviewModel->create([
            'user_id' => Auth::user()->id,
            'book_id' => $bookId,
            'rating' => $request->rating,
            'comments' => $request->comments
        ]));
    }

    public function update(UserReviewRequest $request, $userReviewId)
    {
        $userReview = $this->userReviewModel->findOrFail($userReviewId);
        $this->authorize('update', $userReview);
        $userReview->update($request->all());

        return new UserReviewResource($userReview);
    }

    public function destroy($userReviewId)
    {
        $userReview = $this->userReviewModel->findOrFail($userReviewId);
        $this->authorize('destroy', $userReview);

        $userReview->delete();

        return new DestroyUserReviewResponse($userReview);
    }
}
