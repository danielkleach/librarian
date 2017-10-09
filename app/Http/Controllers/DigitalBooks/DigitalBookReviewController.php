<?php

namespace App\Http\Controllers\DigitalBooks;

use App\BookReview;
use App\DigitalBook;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookReviewRequest;
use App\Http\Resources\BookReview as BookReviewResource;
use App\Http\Responses\BookReviews\DestroyBookReviewResponse;

class DigitalBookReviewController extends Controller
{
    protected $bookModel, $bookReviewModel;

    /**
     * BookReviewController constructor.
     *
     * @param DigitalBook $bookModel
     * @param BookReview $bookReviewModel
     */
    public function __construct(DigitalBook $bookModel, BookReview $bookReviewModel)
    {
        $this->bookModel = $bookModel;
        $this->bookReviewModel = $bookReviewModel;
    }

    public function show($bookReviewId)
    {
        $review = $this->bookReviewModel
            ->with(['user', 'digitalBook'])->findOrFail($bookReviewId);

        return new BookReviewResource($review);
    }

    public function store(BookReviewRequest $request, $bookId)
    {
        $user = Auth::user();
        $book = $this->bookModel->findOrFail($bookId);

        $review = $this->bookReviewModel->createReview($request, $user, $book);

        return new BookReviewResource($review);
    }

    public function update(BookReviewRequest $request, $bookReviewId)
    {
        $bookReview = $this->bookReviewModel->findOrFail($bookReviewId);
        $this->authorize('update', $bookReview);

        $review = $this->bookReviewModel->updateReview($request, $bookReview);

        return new BookReviewResource($review);
    }

    public function destroy($bookReviewId)
    {
        $bookReview = $this->bookReviewModel->findOrFail($bookReviewId);
        $this->authorize('destroy', $bookReview);

        $bookReview->delete();

        return new DestroyBookReviewResponse($bookReview);
    }
}
