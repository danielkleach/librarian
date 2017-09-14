<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BookRequest;
use App\Http\Resources\Book as BookResource;

class BookController extends Controller
{
    protected $bookModel;

    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        return BookResource::collection($this->bookModel
            ->with(['authors', 'category'])->paginate(25));
    }

    public function show($bookId)
    {
        return new BookResource($this->bookModel
            ->with(['authors', 'category', 'owner', 'rentals', 'userReviews.user'])->findOrFail($bookId));
    }

    public function store(BookRequest $request)
    {
        return new BookResource($this->bookModel->create($request->all()));
    }

    public function update(BookRequest $request, $bookId)
    {
        $book = $this->bookModel->find($bookId);
        $book->update($request->all());

        return new BookResource($book);
    }
}
