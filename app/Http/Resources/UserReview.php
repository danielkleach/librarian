<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserReview extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'user_id' => (int) $this->user_id,
            'book_id' => (int) $this->book_id,
            'rating' => $this->rating,
            'comments' => $this->comments,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'user' => User::make($this->whenLoaded('user')),
            'book' => Book::make($this->whenLoaded('book'))
        ];
    }
}
