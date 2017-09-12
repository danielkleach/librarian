<?php

namespace App\Http\Controllers;

use App\Rental;
use Illuminate\Http\Request;

class BookCheckoutController extends Controller
{
    protected $rentalModel;

    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $bookId)
    {
        $rental = $this->rentalModel->checkout($bookId);

        return new StoreRentalResponse($rental);
    }
}
