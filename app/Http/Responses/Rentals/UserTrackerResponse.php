<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;

class UserRentalResponse implements Responsable
{
    protected $rentals;

    public function __construct($rentals)
    {
        $this->rentals = $rentals;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformRental(), 200);
    }

    protected function transformRental()
    {
        return $this->rentals->map(function ($rental) {
            return [
                'id' => (int) $rental->id,
                'user_id' => (int) $rental->user_id,
                'book_id' => (int) $rental->book_id,
                'book_title' => $rental->book->title,
                'book_description' => $rental->book->description,
                'category_id' => (int) $rental->book->category_id,
                'category_name' => $rental->book->category->name,
                'author_id' => (int) $rental->book->author_id,
                'author_name' => $rental->book->author->name,
                'checkout_date' => Carbon::createFromFormat('Y-m-d H:i:s', $rental->checkout_date)
                    ->toDateTimeString(),
                'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $rental->due_date)
                    ->toDateTimeString(),
                'return_date' => $rental->return_date
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $rental->return_date)
                        ->toDateTimeString()
                    : null
            ];
        });
    }
}
