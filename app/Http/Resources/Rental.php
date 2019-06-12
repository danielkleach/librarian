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
            'rentable_id' => (int) $this->rentable_id,
            'rentable_type' => $this->rentable_type,
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

            'rentable' => $this->rentable,

            'user' => User::make($this->whenLoaded('user'))
        ];
    }
}
