<?php

namespace App\Http\Controllers;

use App\Video;
use App\Rental;
use Illuminate\Http\Request;
use App\Http\Resources\Rental as RentalResource;

class VideoCheckinController extends Controller
{
    protected $videoModel;
    protected $rentalModel;

    /**
     * VideoCheckinController constructor.
     *
     * @param Video $videoModel
     * @param Rental $rentalModel
     */
    public function __construct(Video $videoModel, Rental $rentalModel)
    {
        $this->videoModel = $videoModel;
        $this->rentalModel = $rentalModel;
    }

    public function store(Request $request, $videoId, $rentalId)
    {
        $video = $this->videoModel->findOrFail($videoId);
        $rental = $this->rentalModel->findOrFail($rentalId)->checkin($video);

        return new RentalResource($rental);
    }
}
