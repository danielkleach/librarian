<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;

class NewBookResponse implements Responsable
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
                'date_added' => Carbon::createFromFormat('Y-m-d H:i:s', $book->created_at)->format('F j, Y')
            ];
        });
    }
}
