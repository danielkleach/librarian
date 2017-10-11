<?php

namespace App\Http\Controllers\Ebooks;

use App\Ebook;
use App\Http\Controllers\Controller;
use App\Http\Resources\Ebook as BookResource;

class PopularEbookController extends Controller
{
    protected $bookModel;

    /**
     * PopularEbookController constructor.
     *
     * @param Ebook $bookModel
     */
    public function __construct(Ebook $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors'])->popular()->paginate(25);

        return BookResource::collection($books);
    }
}
