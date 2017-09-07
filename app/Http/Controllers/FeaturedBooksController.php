<?php

namespace App\Http\Controllers;

use App\Book;

class FeaturedBooksController extends Controller
{
    protected $bookModel;

    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['author', 'category', 'owner'])
            ->featured()
            ->limit(20)
            ->get();

        return new IndexBookResponse($books);
    }
}
