<?php

namespace App\Http\Controllers;

use App\File;
use App\Author;
use App\Lookup;
use App\DigitalBook;
use App\Http\Requests\DigitalBookRequest;
use App\Http\Resources\DigitalBook as DigitalBookResource;

class DigitalBookController extends Controller
{
    protected $bookModel, $authorModel, $fileModel;

    public function __construct(DigitalBook $bookModel, Author $authorModel, File $fileModel)
    {
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
        $this->fileModel = $fileModel;
    }

    public function index()
    {
        return DigitalBookResource::collection($this->bookModel
            ->with(['authors', 'category'])->paginate(25));
    }

    public function show($bookId)
    {
        return new DigitalBookResource($this->bookModel
            ->with(['authors', 'category', 'files'])->findOrFail($bookId));
    }

    public function store(DigitalBookRequest $request)
    {
        $this->authorize('store', $this->bookModel);

        $lookup = app(Lookup::class);
        $response = $lookup->handle($request);

        $book = $this->bookModel->create([
            'category_id' => $request->category_id,
            'title' => $response->title ?? $request->title,
            'description' => $response->description ?? $request->description,
            'isbn' => $response->isbn ?? $request->isbn,
            'publication_year' => $response->publication_year ?? $request->publication_year,
            'cover_image_url' => $response->cover_image_url ?? null
        ]);

        foreach ($request->files as $file) {
            $path = $file->move(storage_path() . '/files/' . $book->id, $book->id . '-' . $file->getClientOriginalName());
            $this->fileModel->create([
                'book_id' => $book->id,
                'format' => $file->getClientOriginalExtension(),
                'path' => $path,
                'filename' => $file->getClientOriginalName()
            ]);
        }

        if ($response->authors) {
            collect($response->authors)->each(function($authorName) use ($book) {
                $author = $this->authorModel->firstOrCreate(['name' => $authorName]);
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
