<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class IndexFavoriteBookResponse implements Responsable
{
    protected $favorites;

    public function __construct($favorites)
    {
        $this->favorites = $favorites;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformBooks(), 200);
    }

    protected function transformBooks()
    {
        return $this->favorites->map(function ($favorite) {
            return [
                'id' => (int) $favorite->id,
                'book_id' => (int) $favorite->book_id,
                'category_id' => (int) $favorite->book->category_id,
                'category_name' => $favorite->book->category->name,
                'authors' => $favorite->book->authors->map(function ($author) {
                    return [
                        'id' => (int) $author->id,
                        'name' => $author->name,
                    ];
                }),
                'owner_id' => (int) $favorite->book->owner_id ?? null,
                'owner_name' => $favorite->book->owner
                    ? $favorite->book->owner->full_name
                    : null,
                'title' => $favorite->book->title,
                'description' => $favorite->book->description,
                'isbn' => $favorite->book->isbn,
                'publication_year' => (int) $favorite->book->publication_year,
                'location' => $favorite->book->location,
                'status' => $favorite->book->status,
                'featured' => $favorite->book->featured,
                'average_rating' => number_format($favorite->book->getAverageRating(), 1),
                'cover_image_url' => $favorite->book->getFirstMedia('cover_image')
                    ? $favorite->book->getFirstMedia('cover_image')->getUrl()
                    : null
            ];
        });
    }
}
