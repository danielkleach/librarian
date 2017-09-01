<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class CoverImageController extends Controller
{
    protected $bookModel;

    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function store(Request $request, $bookId)
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
