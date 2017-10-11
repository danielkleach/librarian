<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Author extends Resource
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
            'name' => $this->name,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'books' => Book::collection($this->whenLoaded('books')),
            'ebooks' => Ebook::collection($this->whenLoaded('ebooks'))
        ];
    }
}
