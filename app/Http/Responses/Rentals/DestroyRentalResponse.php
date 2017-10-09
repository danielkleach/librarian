<?php

namespace App\Http\Responses\Rentals;

use Illuminate\Contracts\Support\Responsable;

class DestroyRentalResponse implements Responsable
{
    protected $rental;

    public function __construct($rental)
    {
        $this->rental = $rental;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This rental has been deleted.'], 200);
    }
}
