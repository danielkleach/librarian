<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class Rental extends Resource
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
            'checkout_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->checkout_date)
                ->format('F j, Y'),
            'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->due_date)
                ->format('F j, Y'),
            'return_date' => $this->return_date
                ? Carbon::createFromFormat('Y-m-d H:i:s', $this->return_date)
                    ->format('F j, Y')
                : null,
            'created_at' => $this->created_at->format('F j, Y'),
            'updated_at' => $this->updated_at->format('F j, Y'),

            'user' => User::make($this->whenLoaded('user')),
            'book' => Book::make($this->whenLoaded('book'))
        ];
    }
}
