<?php

namespace App\Http\Controllers;

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
                'title' => $book->title,
                'description' => $book->description,
                'cover_image_url' => $book->cover_image_url,
                'avg_rating' => number_format($book->avg_rating, 1)
            ];
        });
    }
}
