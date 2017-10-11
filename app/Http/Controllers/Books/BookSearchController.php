<?php

namespace App\Http\Controllers\Books;

use App\Book;
use App\Ebook;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;

class BookSearchController extends Controller
{
    protected $bookModel, $ebookModel;

    /**
     * BookSearchController constructor.
     *
     * @param Book $bookModel
     * @param Ebook $ebookModel
     */
    public function __construct(Book $bookModel, Ebook $ebookModel)
    {
        $this->bookModel = $bookModel;
        $this->ebookModel = $ebookModel;
    }

    public function index(SearchRequest $request)
    {
        $books = $this->bookModel->search($request->search)->get();
        $ebooks = $this->ebookModel->search($request->search)->get();

        $books->merge($ebooks);

        return $books;
    }
}
