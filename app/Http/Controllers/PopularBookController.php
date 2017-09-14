<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rental;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PopularBookController extends Controller
{
    protected $rentalModel;

    /**
     * PopularBooksController Constructor
     *
     * @param Rental $rentalModel
     */
    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    /**
     * List Books by their number of checkouts.
     *
     * @param Book $bookModel
     * @return PopularBookResponse
     */
    public function index(Book $bookModel)
    {
        $books = new Collection();

        $this->rentalModel
            ->select(DB::raw('count(*) as count, book_id'))
            ->groupBy('book_id')
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get('book_id', 'count')
            ->each(function ($topBook) use ($bookModel, $books) {
                $book = $bookModel->with(['authors', 'category', 'owner'])->where('id', $topBook->book_id)->first();
                $books->push($book);
            });

        return new PopularBookResponse($books);
    }
}
