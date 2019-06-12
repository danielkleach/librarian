<?php

namespace App\Http\Controllers\Ebooks;

use App\Ebook;
use App\Author;
use App\CreateEbook;
use App\Http\Requests\EbookRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Ebook as EbookResource;

class EbookController extends Controller
{
    protected $bookModel, $authorModel, $createEbook;

    /**
     * EbookController constructor.
     *
     * @param Ebook $bookModel
     * @param Author $authorModel
     * @param CreateEbook $createEbook
     */
    public function __construct(
        Ebook $bookModel,
        Author $authorModel,
        CreateEbook $createEbook
    ){
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
        $this->createEbook = $createEbook;
    }

    public function index()
    {
        $books = $this->bookModel->with(['authors', 'category'])->paginate(25);

        return EbookResource::collection($books);
    }

    public function show($bookId)
    {
        $book = $this->bookModel->with(['authors', 'category', 'files'])->findOrFail($bookId);

        return new EbookResource($book);
    }

    public function store(EbookRequest $request)
    {
        $this->authorize('store', $this->bookModel);

        $request = $request->all();
        $book = $this->createEbook->handle($request);

        return new EbookResource($book);
    }

    public function update(EbookRequest $request, $bookId)
    {
        $book = $this->bookModel->find($bookId);
        $this->authorize('update', $book);
        $book->update($request->all());

        return new EbookResource($book);
    }
}
