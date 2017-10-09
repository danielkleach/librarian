<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'rentals' => Rental::collection($this->whenLoaded('rentals')),
            'favorites' => Favorite::collection($this->whenLoaded('favorites')),
            'reviews' => Review::collection($this->whenLoaded('reviews'))
        ];
    }
}
