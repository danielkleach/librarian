<?php

namespace App\Http\Controllers;

use App\Rental;
use Illuminate\Http\Request;

class BookCheckinController extends Controller
{
    protected $rentalModel;

    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $bookId, $rentalId)
    {
        $rental = $this->rentalModel->findOrFail($rentalId);
        $rental->checkin();

        return new UpdateRentalResponse($rental);
    }
}
