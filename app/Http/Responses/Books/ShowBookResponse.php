<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class ShowBookResponse implements Responsable
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
            'title' => $this->book->title,
            'description' => $this->book->description,
            'cover_image' => $this->book->cover_image,
            'isbn' => $this->book->isbn,
            'publication_year' => $this->book->publication_year,
            'owner' => $this->book->owner,
            'status' => $this->book->status,
            'average_rating' => $this->book->getAverageRating()
        ];
    }
}
