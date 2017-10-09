<?php

namespace App\Http\Controllers\DigitalBooks;

use App\DigitalBook;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookAuthorRequest;
use App\Http\Responses\BookAuthors\StoreBookAuthorResponse;
use App\Http\Responses\BookAuthors\DestroyBookAuthorResponse;

class DigitalBookAuthorController extends Controller
{
    protected $bookModel;

    /**
     * DigitalBookAuthorController constructor.
     *
     * @param DigitalBook $bookModel
     */
    public function __construct(DigitalBook $bookModel)
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
