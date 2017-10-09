<?php

namespace App\Http\Controllers\DigitalBooks;

use App\Author;
use App\DigitalBook;
use App\CreateDigitalBook;
use App\Http\Controllers\Controller;
use App\Http\Requests\DigitalBookRequest;
use App\Http\Resources\DigitalBook as DigitalBookResource;

class DigitalBookController extends Controller
{
    protected $bookModel, $authorModel, $createDigitalBook;

    /**
     * DigitalBookController constructor.
     *
     * @param DigitalBook $bookModel
     * @param Author $authorModel
     * @param CreateDigitalBook $createDigitalBook
     */
    public function __construct(
        DigitalBook $bookModel,
        Author $authorModel,
        CreateDigitalBook $createDigitalBook
    ){
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
        $this->createDigitalBook = $createDigitalBook;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors'])->paginate(25);

        return DigitalBookResource::collection($books);
    }

    public function show($bookId)
    {
        $book = $this->bookModel->with(['authors', 'files'])->findOrFail($bookId);

        return new DigitalBookResource($book);
    }

    public function store(DigitalBookRequest $request)
    {
        $this->authorize('store', $this->bookModel);

        $request = $request->all();
        $book = $this->createDigitalBook->handle($request);

        return new DigitalBookResource($book);
    }

    public function update(DigitalBookRequest $request, $bookId)
    {
        $book = $this->bookModel->find($bookId);
        $this->authorize('update', $book);
        $book->update($request->all());

        return new DigitalBookResource($book);
    }
}
