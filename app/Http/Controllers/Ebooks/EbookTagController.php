<?php

namespace App\Http\Controllers\Ebooks;

use App\Ebook;
use Spatie\Tags\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookTagRequest;
use App\Http\Responses\BookTags\StoreBookTagResponse;
use App\Http\Responses\BookTags\DestroyBookTagResponse;

class EbookTagController extends Controller
{
    protected $bookModel, $tagModel;

    /**
     * EbookTagController constructor.
     *
     * @param Ebook $bookModel
     * @param Tag $tagModel
     */
    public function __construct(Ebook $bookModel, Tag $tagModel)
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
