<?php

namespace App\Http\Controllers;

use App\Book;
use App\UserReview;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommendedBookController extends Controller
{
    protected $userReviewModel;

    /**
     * RecommendedBooksController Constructor
     *
     * @param UserReview $userReviewModel
     */
    public function __construct(UserReview $userReviewModel)
    {
        $this->userReviewModel = $userReviewModel;
    }

    /**
     * List the highest rated Books.
     *
     * @param Book $bookModel
     * @return RecommendedBookResponse
     */
    public function index(Book $bookModel)
    {
        $books = new Collection();

        $this->userReviewModel
            ->select(DB::raw('avg(rating) as avg_rating, book_id'))
            ->groupBy('book_id')
            ->orderBy('avg_rating', 'desc')
            ->limit(20)
            ->get('book_id', 'avg_rating')
            ->each(function ($topBook) use ($bookModel, $books) {
                $book = $bookModel->with(['authors', 'category', 'owner'])->where('id', $topBook->book_id)->first();
                $books->push($book);
            });

        return new RecommendedBookResponse($books);
    }
}
