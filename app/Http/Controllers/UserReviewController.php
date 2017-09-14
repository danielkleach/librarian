<?php

namespace App\Http\Controllers;

use App\Book;
use App\Events\BookRated;
use App\UserReview;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserReviewRequest;
use App\Http\Resources\UserReview as UserReviewResource;

class UserReviewController extends Controller
{
    protected $bookModel, $userReviewModel;

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
        $book = $this->bookModel->findOrFail($bookId);

        $review = $this->userReviewModel->create([
            'user_id' => Auth::user()->id,
            'book_id' => $book->id,
            'rating' => $request->rating,
            'comments' => $request->comments
        ]);

        event(new BookRated($review));

        return new UserReviewResource($review);
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
