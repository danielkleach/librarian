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
        return response()->json($this->transformBook(), 200);
    }

    protected function transformBook()
    {
        return [
            'id' => (int) $this->book->id,
            'category_id' => (int) $this->book->category_id,
            'category_name' => $this->book->category->name,
            'authors' => $this->book->authors->map(function ($author) {
                return [
                    'id' => (int) $author->id,
                    'name' => $author->name,
                ];
            }),
            'owner_id' => (int) $this->book->owner_id ?? null,
            'owner_name' => $this->book->owner
                ? $this->book->owner->full_name
                : null,
            'title' => $this->book->title,
            'description' => $this->book->description,
            'isbn' => $this->book->isbn,
            'publication_year' => (int) $this->book->publication_year,
            'location' => $this->book->location,
            'status' => $this->book->status,
            'featured' => $this->book->featured,
            'average_rating' => number_format($this->book->getAverageRating(), 1),
            'cover_image_url' => $this->book->getFirstMedia('cover_image')
                ? $this->book->getFirstMedia('cover_image')->getUrl()
                : null,
            'user_reviews' => $this->book->userReviews->map(function ($review) {
                return [
                    'id' => (int) $review->id,
                    'user_id' => (int) $review->user_id,
                    'user_name' => $review->user->full_name,
                    'rating' => $review->rating,
                    'comments' => $review->comments
                ];
            })
        ];
    }
}
