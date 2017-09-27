<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class File extends Resource
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
            'book_id' => (int) $this->book_id,
            'format' => $this->format,
            'path' => $this->path,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'book' => Book::make($this->whenLoaded('book'))
        ];
    }
}
