<?php

namespace App\Http\Responses\Books;

use Illuminate\Contracts\Support\Responsable;

class RecommendedBookResponse implements Responsable
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
                'authors' => $book->authors->map(function ($author) {
                    return [
                        'id' => (int) $author->id,
                        'name' => $author->name,
                    ];
                }),
                'owner_id' => (int) $book->owner_id ?? null,
                'owner_name' => $book->owner
                    ? $book->owner->full_name
                    : null,
                'title' => $book->title,
                'description' => $book->description,
                'isbn' => $book->isbn,
                'publication_year' => $book->publication_year,
                'location' => $book->location,
                'status' => $book->status,
                'average_rating' => number_format($book->getAverageRating(), 1),
                'cover_image_url' => $book->getFirstMedia('cover_image')
                    ? $book->getFirstMedia('cover_image')->getUrl()
                    : null,
            ];
        });
    }
}
