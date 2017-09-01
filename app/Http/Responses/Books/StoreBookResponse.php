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
        return response()->json($this->transformBook());
    }

    protected function transformBook()
    {
        return [
            'id' => (int) $this->book->id,
            'category_id' => (int) $this->book->category_id,
            'author_id' => (int) $this->book->author_id,
            'owner_id' => (int) $this->book->owner_id,
            'title' => $this->book->title,
            'description' => $this->book->description,
            'isbn' => $this->book->isbn,
            'publication_year' => $this->book->publication_year,
            'status' => $this->book->status,
            'cover_image_url' => $this->book->getFirstMedia('cover_image')
                ? $this->book->getFirstMedia('cover_image')->getUrl()
                : null
        ];
    }
}
