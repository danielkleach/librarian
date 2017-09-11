<?php

namespace App\Http\Controllers;

use App\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookCheckinController extends Controller
{
    protected $rentalModel;

    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $bookId)
    {
        $rental = $this->rentalModel
            ->where('user_id', '=', Auth::user()->id)
            ->where('book_id', '=', $bookId)
            ->whereNull('return_date')
            ->firstOrFail();

        $rental->update([
            'return_date' => Carbon::now()->toDateTimeString(),
        ]);

        return new UpdateRentalResponse($rental);
    }
}
