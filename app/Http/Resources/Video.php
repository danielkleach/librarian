<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Video extends Resource
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
            'owner_id' => $this->owner_id
                ? (int) $this->owner_id
                : null,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'runtime' => $this->runtime,
            'thumbnail_path' => $this->thumbnail_path,
            'header_path' => $this->header_path,
            'tags' => $this->tags,
            'location' => $this->location,
            'featured' => $this->featured,
            'total_rentals' => $this->total_rentals
                ? (int) $this->total_rentals
                : null,
            'rating' => $this->rating
                ? number_format($this->rating, 2)
                : null,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'actors' => Actor::collection($this->whenLoaded('actors')),
            'owner' => User::make($this->whenLoaded('owner')),
            'rentals' => Rental::collection($this->whenLoaded('rentals')),
            'reviews' => VideoReview::collection($this->whenLoaded('reviews'))
        ];
    }
}
