<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class ShowUserResponse implements Responsable
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformUser(), 200);
    }

    protected function transformUser()
    {
        return [
            'id' => (int) $this->user->id,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'checked_out' => $this->user->getCheckedOut()->map(function ($tracker) {
                return [
                    'id' => (int) $tracker->id,
                    'book_id' => (int) $tracker->book_id,
                    'category_id' => (int) $tracker->book->category_id,
                    'category_name' => $tracker->book->category->name,
                    'author_id' => (int) $tracker->book->author_id,
                    'author_name' => $tracker->book->author->name,
                    'book_title' => $tracker->book->title,
                    'checkout_date' => $tracker->checkout_date->toDateTimeString(),
                    'due_date' => $tracker->due_date->toDateTimeString()
                ];
            }),
            'overdue' => $this->user->getOverdue()->map(function ($tracker) {
                return [
                    'id' => (int) $tracker->id,
                    'book_id' => (int) $tracker->book_id,
                    'category_id' => (int) $tracker->book->category_id,
                    'category_name' => $tracker->book->category->name,
                    'author_id' => (int) $tracker->book->author_id,
                    'author_name' => $tracker->book->author->name,
                    'book_title' => $tracker->book->title,
                    'checkout_date' => $tracker->checkout_date->toDateTimeString(),
                    'due_date' => $tracker->due_date->toDateTimeString()
                ];
            }),
            'user_reviews' => $this->user->userReviews->map(function ($review) {
                return [
                    'id' => (int) $review->id,
                    'book_id' => (int) $review->book_id,
                    'book_title' => $review->book->title,
                    'rating' => $review->rating,
                    'comments' => $review->comments
                ];
            })
        ];
    }
}
