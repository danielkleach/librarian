<?php

namespace App\Http\Controllers;

use App\Book;
use App\UserReview;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserReviewRequest;
use App\Http\Resources\UserReview as UserReviewResource;

class UserReviewController extends Controller
{
    protected $bookModel, $userReviewModel;

    /**
     * UserReviewController constructor.
     *
     * @param Book $bookModel
     * @param UserReview $userReviewModel
     */
    public function __construct(Book $bookModel, UserReview $userReviewModel)
    {
        $this->bookModel = $bookModel;
        $this->userReviewModel = $userReviewModel;
    }

    public function show($userReviewId)
    {
        return new UserReviewResource($this->userReviewModel
            ->with(['user', 'book'])->findOrFail($userReviewId));
    }

    public function store(UserReviewRequest $request, $bookId)
    {
        $user = Auth::user();
        $book = $this->bookModel->findOrFail($bookId);

        return new UserReviewResource($this->userReviewModel->createReview($request, $user, $book));
    }

    public function update(UserReviewRequest $request, $userReviewId)
    {
        $userReview = $this->userReviewModel->findOrFail($userReviewId);
        $this->authorize('update', $userReview);

        return new UserReviewResource($this->userReviewModel->updateReview($request, $userReview));
    }

    public function destroy($userReviewId)
    {
        $userReview = $this->userReviewModel->findOrFail($userReviewId);
        $this->authorize('destroy', $userReview);

        $userReview->delete();

        return new DestroyUserReviewResponse($userReview);
    }
}
