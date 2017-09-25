<?php

namespace App\Http\Controllers;

use App\Author;
use App\Lookup;
use App\DigitalBook;
use App\Http\Requests\DigitalBookRequest;
use App\Http\Resources\DigitalBook as DigitalBookResource;

class DigitalBookController extends Controller
{
    protected $bookModel, $authorModel;

    public function __construct(DigitalBook $bookModel, Author $authorModel)
    {
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
    }

    public function index()
    {
        return DigitalBookResource::collection($this->bookModel
            ->with(['authors', 'category'])->paginate(25));
    }

    public function show($bookId)
    {
        return new DigitalBookResource($this->bookModel
            ->with(['authors', 'category'])->findOrFail($bookId));
    }

    public function store(DigitalBookRequest $request)
    {
        $this->authorize('store', $this->bookModel);

        $lookup = app(Lookup::class);
        $response = $lookup->handle($request);

        $book = $this->bookModel->create([
            'category_id' => $request->category_id,
            'title' => $response->title,
            'description' => $response->description,
            'isbn' => $response->isbn,
            'publication_year' => $response->publication_year,
            'cover_image_url' => $response->cover_image_url ?? null
        ]);

        if ($response->authors) {
            collect($response->authors)->each(function($authorName) use ($book) {
                $author = $this->authorModel->where('name', $authorName)->first();

                if (!$author) {
                    $author = $this->authorModel->create(['name' => $authorName]);
                }

                $book->authors()->attach($author);
            });
        }

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
