<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Rental as RentalResource;

class BookCheckoutController extends Controller
{
    protected $bookModel, $rentalModel;

    /**
     * BookCheckoutController constructor.
     * @param Book $bookModel
     * @param Rental $rentalModel
     */
    public function __construct(Book $bookModel, Rental $rentalModel)
    {
        $this->bookModel = $bookModel;
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = $this->bookModel->findOrFail($bookId);

        return new RentalResource($this->rentalModel->checkout($user, $book));
    }
}
