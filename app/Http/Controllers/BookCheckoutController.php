<?php

namespace App\Http\Controllers;

use App\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookCheckoutController extends Controller
{
    protected $rentalModel;

    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $bookId)
    {
        $rental = $this->rentalModel->create([
            'user_id' => Auth::user()->id,
            'book_id' => $bookId,
            'checkout_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addWeeks(2)->toDateTimeString()
        ]);

        return new StoreRentalResponse($rental);
    }
}
