<?php

namespace App\Http\Controllers;

use App\Rental;

class UserRentalController extends Controller
{
    protected $rentalModel;

    public function __construct(Rental $rentalModel)
    {
        $this->rentalModel = $rentalModel;
    }

    public function index($userId)
    {
        $rental = $this->rentalModel->with(['book.category', 'book.author'])
            ->where('user_id', '=', $userId)->paginate(20);

        return new UserRentalResponse($rental);
    }
}
