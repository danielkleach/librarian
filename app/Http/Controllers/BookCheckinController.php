<?php

namespace App\Http\Controllers;

use App\Book;
use App\Rental;
use Illuminate\Http\Request;
use App\Http\Resources\Rental as RentalResource;

class BookCheckinController extends Controller
{
    protected $bookModel;
    protected $rentalModel;

    /**
     * BookCheckinController constructor.
     *
     * @param Book $bookModel
     * @param Rental $rentalModel
     */
    public function __construct(Book $bookModel, Rental $rentalModel)
    {
        $this->bookModel = $bookModel;
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $bookId, $rentalId)
    {
        $book = $this->bookModel->findOrFail($bookId);

        return new RentalResource($this->rentalModel->findOrFail($rentalId)->checkin($book));
    }
}
