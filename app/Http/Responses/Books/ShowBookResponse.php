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
            'category_name' => $this->book->category->name,
            'author_id' => (int) $this->book->author_id,
            'author_name' => $this->book->author->name,
            'owner_id' => (int) $this->book->owner_id,
            'owner_name' => $this->book->owner->full_name,
            'title' => $this->book->title,
            'description' => $this->book->description,
            'isbn' => $this->book->isbn,
            'publication_year' => (int) $this->book->publication_year,
            'location' => $this->book->location,
            'status' => $this->book->status,
            'average_rating' => $this->book->getAverageRating(),
            'cover_image_url' => $this->book->getFirstMedia('cover_image')
                ? $this->book->getFirstMedia('cover_image')->getUrl()
                : null,
            'user_reviews' => $this->book->userReviews->map(function ($review) {
                return [
                    'id' => (int) $review->id,
                    'user_id' => (int) $review->user_id,
                    'user_name' => $review->user->first_name,
                    'rating' => $review->rating,
                    'comments' => $review->comments
                ];
            })
        ];
    }
}
