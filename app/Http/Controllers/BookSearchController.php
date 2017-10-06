<?php

namespace App\Http\Controllers;

use App\Book;
use App\DigitalBook;
use App\Http\Requests\SearchRequest;

class BookSearchController extends Controller
{
    protected $bookModel, $digitalBookModel;

    /**
     * BookSearchController constructor.
     *
     * @param Book $bookModel
     * @param DigitalBook $digitalBookModel
     */
    public function __construct(Book $bookModel, DigitalBook $digitalBookModel)
    {
        $this->bookModel = $bookModel;
        $this->digitalBookModel = $digitalBookModel;
    }

    public function index(SearchRequest $request)
    {
        $books = $this->bookModel->search($request->search)->get();
        $digitalBooks = $this->digitalBookModel->search($request->search)->get();

        $books->merge($digitalBooks);

        return $books;
    }
}
