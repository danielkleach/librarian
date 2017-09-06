<?php

namespace App\Http\Controllers;

use App\Book;
use App\Tracker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PopularBooksController extends Controller
{
    protected $trackerModel;

    /**
     * PopularBooksController Constructor
     *
     * @param Tracker $trackerModel
     */
    public function __construct(Tracker $trackerModel)
    {
        $this->trackerModel = $trackerModel;
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

        $this->trackerModel
            ->select(DB::raw('count(*) as count, book_id'))
            ->groupBy('book_id')
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get('book_id', 'count')
            ->each(function ($topBook) use ($bookModel, $books) {
                $book = $bookModel->find($topBook->book_id);
                $books->push((object) [
                    'id' => $topBook->book_id,
                    'title' => $book->title,
                    'description' => $book->description,
                    'cover_image_url' => $book->getFirstMedia('cover_image')
                        ? $book->getFirstMedia('cover_image')->getUrl()
                        : null
                ]);
            });

        return new PopularBookResponse($books);
    }
}
