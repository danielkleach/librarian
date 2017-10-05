<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\Book as BookResource;

class NewBookController extends Controller
{
    protected $bookModel;

    /**
     * NewBookController constructor.
     *
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors', 'owner'])->new()->paginate(25);

        return BookResource::collection($books);
    }
}
