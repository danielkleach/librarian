<?php

namespace App\Http\Controllers;

use App\Rental;

class RentalController extends Controller
{
    protected $rentalModel;

    /**
     * RentalController constructor.
     *
     * @param Rental $rentalModel
     */
    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    public function destroy($rentalId)
    {
        $rental = $this->rentalModel->findOrFail($rentalId);

        $rental->delete();

        return new DestroyRentalResponse($rental);
    }
}
