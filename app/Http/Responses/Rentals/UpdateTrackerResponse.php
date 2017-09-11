<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;

class UpdateRentalResponse implements Responsable
{
    protected $rental;

    public function __construct($rental)
    {
        $this->rental = $rental;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformRental(), 200);
    }

    protected function transformRental()
    {
        return [
            'id' => (int) $this->rental->id,
            'user_id' => (int) $this->rental->user_id,
            'book_id' => (int) $this->rental->book_id,
            'checkout_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->rental->checkout_date)
                ->toDateTimeString(),
            'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->rental->due_date)
                ->toDateTimeString(),
            'return_date' => $this->rental->return_date
                ? Carbon::createFromFormat('Y-m-d H:i:s', $this->rental->return_date)
                    ->toDateTimeString()
                : null
        ];
    }
}
