<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    protected $bookModel;

    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['author', 'category', 'owner'])->paginate(25);

        return new IndexBookResponse($books);
    }

    public function show($bookId)
    {
        $book = $this->bookModel->with(['author', 'category', 'owner', 'userReviews.user'])->findOrFail($bookId);

        return new ShowBookResponse($book);
    }

    public function store(BookRequest $request)
    {
        $book = $this->bookModel->create($request->all());

        return new StoreBookResponse($book);
    }

    public function update(BookRequest $request, $bookId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        $book->update($request->all());

        return new UpdateBookResponse($book);
    }
}
