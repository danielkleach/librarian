<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Review extends Resource
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
            'reviewable_id' => (int) $this->reviewable_id,
            'reviewable_type' => $this->reviewable_type,
            'rating' => (int) $this->rating,
            'comments' => $this->comments,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'reviewable' => $this->reviewable,

            'user' => User::make($this->whenLoaded('user'))
        ];
    }
}
