<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Favorite extends Resource
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
            'favoritable_id' => (int) $this->favoritable_id,
            'favoritable_type' => $this->favoritable_type,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'favoritable' => $this->favoritable,

            'user' => User::make($this->whenLoaded('user'))
        ];
    }
}
