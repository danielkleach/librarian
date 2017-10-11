<?php

namespace App\Http\Controllers\Ebooks;

use App\Ebook;
use App\Http\Controllers\Controller;
use App\Http\Resources\Ebook as BookResource;

class RecommendedEbookController extends Controller
{
    protected $bookModel;

    /**
     * RecommendedEbookController constructor.
     *
     * @param Ebook $bookModel
     */
    public function __construct(Ebook $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors', 'category'])->recommended()->paginate(25);

        return BookResource::collection($books);
    }
}
