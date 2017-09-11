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
        return response()->json($this->transformBooks(), 200);
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
                'owner_id' => (int) $book->owner_id ?? null,
                'owner_name' => $book->owner
                    ? $book->owner->full_name
                    : null,
                'title' => $book->title,
                'description' => $book->description,
                'isbn' => $book->isbn,
                'publication_year' => (int) $book->publication_year,
                'location' => $book->location,
                'status' => $book->status,
                'featured' => $book->featured,
                'average_rating' => $book->getAverageRating(),
                'cover_image_url' => $book->getFirstMedia('cover_image')
                    ? $book->getFirstMedia('cover_image')->getUrl()
                    : null
            ];
        });
    }
}
