<?php

namespace App\Http\Controllers;

use App\Rental;
use Illuminate\Http\Request;
use App\Http\Resources\Rental as RentalResource;

class BookCheckoutController extends Controller
{
    protected $rentalModel;

    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $bookId)
    {
        return new RentalResource($this->rentalModel->checkout($bookId));
    }
}
