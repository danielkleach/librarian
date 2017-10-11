<?php

namespace App\Http\Controllers\Ebooks;

use App\Ebook;
use App\Http\Controllers\Controller;
use App\Http\Resources\Ebook as BookResource;

class NewEbookController extends Controller
{
    protected $bookModel;

    /**
     * NewEbookController constructor.
     *
     * @param Ebook $bookModel
     */
    public function __construct(Ebook $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors'])->latest()->paginate(25);

        return BookResource::collection($books);
    }
}
