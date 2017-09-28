<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Lookup;
use App\Http\Requests\BookRequest;
use App\Http\Resources\Book as BookResource;

class BookController extends Controller
{
    protected $bookModel, $authorModel;

    public function __construct(Book $bookModel, Author $authorModel)
    {
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
    }

    public function index()
    {
        return BookResource::collection($this->bookModel
            ->with(['authors'])->paginate(25));
    }

    public function show($bookId)
    {
        return new BookResource($this->bookModel
            ->with(['authors', 'owner'])->findOrFail($bookId));
    }

    public function store(BookRequest $request)
    {
        $this->authorize('store', $this->bookModel);

        $lookup = app(Lookup::class);
        $response = $lookup->handle($request);

        $book = $this->bookModel->create([
            'owner_id' => $request->owner_id ?? null,
            'title' => $response->title ?? $request->title,
            'description' => $response->description ?? $request->description,
            'isbn' => $response->isbn ?? $request->isbn,
            'publication_year' => $response->publication_year ?? $request->publication_year,
            'location' => $request->location,
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

        return new BookResource($book);
    }

    public function update(BookRequest $request, $bookId)
    {
        $book = $this->bookModel->find($bookId);
        $this->authorize('update', $book);
        $book->update($request->all());

        return new BookResource($book);
    }
}
