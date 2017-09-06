<?php

namespace App\Http\Controllers;

use App\Book;

class NewBooksController extends Controller
{
    protected $bookModel;

    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['author', 'category', 'owner'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return new NewBookResponse($books);
    }
}
