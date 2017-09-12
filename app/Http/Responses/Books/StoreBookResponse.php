<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class StoreBookResponse implements Responsable
{
    protected $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformBook(), 201);
    }

    protected function transformBook()
    {
        return [
            'id' => (int) $this->book->id,
            'category_id' => (int) $this->book->category_id,
            'authors' => $this->book->authors->map(function ($author) {
                return [
                    'id' => (int) $author->id,
                    'name' => $author->name,
                ];
            }),
            'owner_id' => (int) $this->book->owner_id ?? null,
            'title' => $this->book->title,
            'description' => $this->book->description,
            'isbn' => $this->book->isbn,
            'publication_year' => $this->book->publication_year,
            'status' => $this->book->status,
            'featured' => $this->book->featured,
            'cover_image_url' => $this->book->getFirstMedia('cover_image')
                ? $this->book->getFirstMedia('cover_image')->getUrl()
                : null
        ];
    }
}
