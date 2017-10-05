<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class VideoReview extends Resource
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
            'video_id' => (int) $this->video_id,
            'rating' => $this->rating,
            'comments' => $this->comments,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'user' => User::make($this->whenLoaded('user')),
            'video' => Video::make($this->whenLoaded('video'))
        ];
    }
}
