<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookModel;

    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->paginate(25);

        return new IndexBookResponse($books);
    }

    public function show($bookId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        return new ShowBookResponse($book);
    }

    public function store(Request $request)
    {
        $book = $this->bookModel->create($request->all());

        return new StoreBookResponse($book);
    }

    public function update(Request $request, $bookId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        $book->update($request->all());

        return new UpdateBookResponse($book);
    }

    public function destroy($bookId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        $book->delete();

        return new DestroyBookResponse($book);
    }
}
