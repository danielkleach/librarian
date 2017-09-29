<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\CoverImageRequest;

class CoverImageController extends Controller
{
    protected $bookModel;

    /**
     * CoverImageController constructor.
     *
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function store(CoverImageRequest $request, $bookId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        $coverImage = $book->coverImage->save($request->cover_image);

        return new StoreCoverImageResponse($coverImage);
    }

    public function destroy($bookId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        $coverImage = $book->coverImage->delete();

        return new DestroyCoverImageResponse($coverImage);
    }
}
