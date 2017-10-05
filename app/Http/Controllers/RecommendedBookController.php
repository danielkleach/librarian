<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\Book as BookResource;

class RecommendedBookController extends Controller
{
    protected $bookModel;

    /**
     * RecommendedBookController constructor.
     *
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors', 'owner'])->recommended()->paginate(25);

        return BookResource::collection($books);
    }
}
