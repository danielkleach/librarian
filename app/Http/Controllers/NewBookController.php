<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\Book as BookResource;

class NewBookController extends Controller
{
    protected $bookModel;

    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        return BookResource::collection($this->bookModel->with(['authors', 'category', 'owner'])
            ->orderBy('created_at', 'desc')->paginate(25));
    }
}
