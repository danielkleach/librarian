<?php

namespace App\Http\Controllers\Books;

use App\Book;
use App\Author;
use App\CreateBook;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book as BookResource;

class BookController extends Controller
{
    protected $bookModel, $authorModel, $createBook;

    /**
     * BookController constructor.
     *
     * @param Book $bookModel
     * @param Author $authorModel
     * @param CreateBook $createBook
     */
    public function __construct(
        Book $bookModel,
        Author $authorModel,
        CreateBook $createBook
    ){
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
        $this->createBook = $createBook;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors'])->paginate(25);

        return BookResource::collection($books);
    }

    public function show($bookId)
    {
        $book = $this->bookModel->with(['authors', 'owner'])->findOrFail($bookId);

        return new BookResource($book);
    }

    public function store(BookRequest $request)
    {
        $this->authorize('store', $this->bookModel);

        $request = $request->all();
        $book = $this->createBook->handle($request);

        return new BookResource($book);
    }

    public function update(BookRequest $request, $bookId)
    {
        $book = $this->bookModel->find($bookId);
        $this->authorize('update', $book);
        $book->update($request->all());

        return new BookResource($book);
    }
}
