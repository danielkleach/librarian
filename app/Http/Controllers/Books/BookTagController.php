<?php

namespace App\Http\Controllers\Books;

use App\Book;
use Spatie\Tags\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookTagRequest;
use App\Http\Responses\BookTags\StoreBookTagResponse;
use App\Http\Responses\BookTags\DestroyBookTagResponse;

class BookTagController extends Controller
{
    protected $bookModel, $tagModel;

    /**
     * BookTagController constructor.
     *
     * @param Book $bookModel
     * @param Tag $tagModel
     */
    public function __construct(Book $bookModel, Tag $tagModel)
    {
        $this->bookModel = $bookModel;
        $this->tagModel = $tagModel;
    }

    public function store(BookTagRequest $request, $bookId)
    {
        $book = $this->bookModel->findOrFail($bookId);
        $tag = $this->tagModel->findOrCreate($request->tag);

        $book->attachTag($tag);

        return new StoreBookTagResponse($book);
    }

    public function destroy($bookId, $tag)
    {
        $book = $this->bookModel->findOrFail($bookId);

        $book->detachTag($tag);

        return new DestroyBookTagResponse($book);
    }
}
