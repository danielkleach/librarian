<?php

namespace App\Http\Controllers\Books;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book as BookResource;

class PopularBookController extends Controller
{
    protected $bookModel;

    /**
     * PopularBookController constructor.
     *
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors', 'owner'])->popular()->paginate(25);

        return BookResource::collection($books);
    }
}
