<?php

namespace App\Http\Controllers\Books;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookAuthorRequest;
use App\Http\Responses\BookAuthors\StoreBookAuthorResponse;
use App\Http\Responses\BookAuthors\DestroyBookAuthorResponse;

class BookAuthorController extends Controller
{
    protected $bookModel;

    /**
     * BookAuthorController constructor.
     *
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function store(BookAuthorRequest $request, $bookId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        $book->authors()->attach($request->author_id);

        return new StoreBookAuthorResponse($book);
    }

    public function destroy($bookId, $authorId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        $book->authors()->detach($authorId);

        return new DestroyBookAuthorResponse($book);
    }
}
