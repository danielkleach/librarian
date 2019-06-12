<?php

namespace App\Http\Controllers\Ebooks;

use App\BookLookup;
use App\CreateEbook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Book as BookResource;

class EbookLookupController extends Controller
{
    protected $lookup, $createEbook;

    /**
     * EbookLookupController constructor.
     *
     * @param BookLookup $lookup
     * @param CreateEbook $createEbook
     */
    public function __construct(BookLookup $lookup, CreateEbook $createEbook)
    {
        $this->lookup = $lookup;
        $this->createEbook = $createEbook;
    }

    public function store(Request $request)
    {
        $response = $this->lookup->handle($request->isbn);

        $book = $this->createEbook->handle($response);

        return new BookResource($book);
    }
}
