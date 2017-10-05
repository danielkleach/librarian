<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\Book as BookResource;

class FeaturedBookController extends Controller
{
    protected $bookModel;

    /**
     * FeaturedBookController constructor.
     *
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors', 'owner'])->featured()->paginate(25);

        return BookResource::collection($books);
    }
}
