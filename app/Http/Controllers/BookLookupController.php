<?php

namespace App\Http\Controllers;

use App\Lookup;
use App\CreateBook;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BookResource;

class BookLookupController extends Controller
{
    protected $lookup, $createBook;

    /**
     * BookLookupController constructor.
     *
     * @param Lookup $lookup
     * @param CreateBook $createBook
     */
    public function __construct(Lookup $lookup, CreateBook $createBook)
    {
        $this->lookup = $lookup;
        $this->createBook = $createBook;
    }

    public function store(Request $request)
    {
        $response = $this->lookup->handle($request->isbn);

        $book = $this->createBook->handle($response);

        return new BookResource($book);
    }
}