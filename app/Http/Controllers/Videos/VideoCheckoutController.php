<?php

namespace App\Http\Controllers\Videos;

use App\Video;
use App\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Rental as RentalResource;

class VideoCheckoutController extends Controller
{
    protected $videoModel, $rentalModel;

    /**
     * VideoCheckoutController constructor.
     *
     * @param Video $videoModel
     * @param Rental $rentalModel
     */
    public function __construct(Video $videoModel, Rental $rentalModel)
    {
        $this->videoModel = $videoModel;
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $videoId)
    {
        $video = $this->videoModel->findOrFail($videoId);
        $rental = $this->rentalModel->checkout($request->user(), $video);

        return new RentalResource($rental);
    }
}
