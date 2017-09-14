<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Book extends Resource
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
            'category_id' => (int) $this->category_id,
            'owner_id' => $this->owner_id
                ? (int) $this->owner_id
                : null,
            'title' => $this->title,
            'description' => $this->description,
            'isbn' => $this->isbn,
            'publication_year' => (int) $this->publication_year,
            'location' => $this->location,
            'status' => $this->status,
            'featured' => $this->featured,
            'total_rentals' => $this->total_rentals
                ? (int) $this->total_rentals
                : null,
            'rating' => $this->rating
                ? number_format($this->rating, 2)
                : null,
            'cover_image_url' => $this->getFirstMedia('cover_image')
                ? $this->getFirstMedia('cover_image')->getUrl()
                : null,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'authors' => Author::collection($this->whenLoaded('authors')),
            'category' => Category::make($this->whenLoaded('category')),
            'owner' => User::make($this->whenLoaded('owner')),
            'rentals' => Rental::collection($this->whenLoaded('rentals')),
            'user_reviews' => UserReview::collection($this->whenLoaded('userReviews'))
        ];
    }
}
