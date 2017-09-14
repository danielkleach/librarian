<?php

namespace App\Http\Controllers;

use App\Rental;
use Illuminate\Http\Request;
use App\Http\Resources\Rental as RentalResource;

class BookCheckinController extends Controller
{
    protected $rentalModel;

    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $bookId, $rentalId)
    {
        return new RentalResource($this->rentalModel->findOrFail($rentalId)->checkin());
    }
}
