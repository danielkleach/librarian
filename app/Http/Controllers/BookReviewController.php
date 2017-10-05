<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BookReviewRequest;
use App\Http\Resources\BookReview as BookReviewResource;

class BookReviewController extends Controller
{
    protected $bookModel, $bookReviewModel;

    /**
     * BookReviewController constructor.
     *
     * @param Book $bookModel
     * @param BookReview $bookReviewModel
     */
    public function __construct(Book $bookModel, BookReview $bookReviewModel)
    {
        $this->bookModel = $bookModel;
        $this->bookReviewModel = $bookReviewModel;
    }

    public function show($bookReviewId)
    {
        return new BookReviewResource($this->bookReviewModel
            ->with(['user', 'book'])->findOrFail($bookReviewId));
    }

    public function store(BookReviewRequest $request, $bookId)
    {
        $user = Auth::user();
        $book = $this->bookModel->findOrFail($bookId);

        return new BookReviewResource($this->bookReviewModel->createReview($request, $user, $book));
    }

    public function update(BookReviewRequest $request, $bookReviewId)
    {
        $bookReview = $this->bookReviewModel->findOrFail($bookReviewId);
        $this->authorize('update', $bookReview);

        return new BookReviewResource($this->bookReviewModel->updateReview($request, $bookReview));
    }

    public function destroy($bookReviewId)
    {
        $bookReview = $this->bookReviewModel->findOrFail($bookReviewId);
        $this->authorize('destroy', $bookReview);

        $bookReview->delete();

        return new DestroyBookReviewResponse($bookReview);
    }
}
