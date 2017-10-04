<?php

namespace App\Http\Controllers;

use App\BookLookup;
use App\CreateDigitalBook;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BookResource;

class DigitalBookLookupController extends Controller
{
    protected $lookup, $createDigitalBook;

    /**
     * DigitalBookLookupController constructor.
     *
     * @param BookLookup $lookup
     * @param CreateDigitalBook $createDigitalBook
     */
    public function __construct(BookLookup $lookup, CreateDigitalBook $createDigitalBook)
    {
        $this->lookup = $lookup;
        $this->createDigitalBook = $createDigitalBook;
    }

    public function store(Request $request)
    {
        $response = $this->lookup->handle($request->isbn);

        $book = $this->createDigitalBook->handle($response);

        return new BookResource($book);
    }
}
