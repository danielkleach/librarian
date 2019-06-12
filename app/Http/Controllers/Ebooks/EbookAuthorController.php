<?php

namespace App\Http\Controllers\Ebooks;

use App\Ebook;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookAuthorRequest;
use App\Http\Responses\BookAuthors\StoreBookAuthorResponse;
use App\Http\Responses\BookAuthors\DestroyBookAuthorResponse;

class EbookAuthorController extends Controller
{
    protected $bookModel;

    /**
     * EbookAuthorController constructor.
     *
     * @param Ebook $bookModel
     */
    public function __construct(Ebook $bookModel)
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
