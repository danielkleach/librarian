<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DigitalBook extends Resource
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
            'title' => $this->title,
            'description' => $this->description,
            'isbn' => $this->isbn,
            'publication_year' => (int) $this->publication_year,
            'featured' => $this->featured,
            'download_count' => $this->download_count
                ? (int) $this->download_count
                : null,
            'rating' => $this->rating
                ? number_format($this->rating, 2)
                : null,
            'cover_image_url' => $this->cover_image_url,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'authors' => Author::collection($this->whenLoaded('authors')),
            'files' => File::collection($this->whenLoaded('files')),
            'downloads' => Download::collection($this->whenLoaded('downloads')),
            'user_reviews' => UserReview::collection($this->whenLoaded('userReviews'))
        ];
    }
}
