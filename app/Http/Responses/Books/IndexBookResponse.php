<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class IndexBookResponse implements Responsable
{
    protected $books;

    public function __construct($books)
    {
        $this->books = $books;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformBooks());
    }

    protected function transformBooks()
    {
        return $this->books->map(function ($book) {
            return [
                'id' => (int) $book->id,
                'category_id' => (int) $book->category_id,
                'category_name' => $book->category->name,
                'author_id' => (int) $book->author_id,
                'author_name' => $book->author->name,
                'title' => $book->title,
                'description' => $book->description,
                'cover_image' => $book->cover_image,
                'isbn' => $book->isbn,
                'publication_year' => $book->publication_year,
                'owner' => $book->owner,
                'location' => $book->location,
                'status' => $book->status,
                'average_rating' => $book->getAverageRating()
            ];
        });
    }
}
