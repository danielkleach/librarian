<?php

namespace App\Http\Controllers\DigitalBooks;

use App\DigitalBook;
use App\Http\Controllers\Controller;
use App\Http\Resources\DigitalBook as BookResource;

class NewDigitalBookController extends Controller
{
    protected $bookModel;

    /**
     * NewDigitalBookController constructor.
     *
     * @param DigitalBook $bookModel
     */
    public function __construct(DigitalBook $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors'])->new()->paginate(25);

        return BookResource::collection($books);
    }
}
