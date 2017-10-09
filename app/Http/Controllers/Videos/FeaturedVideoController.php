<?php

namespace App\Http\Controllers\Videos;

use App\Video;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video as VideoResource;

class FeaturedVideoController extends Controller
{
    protected $videoModel;

    /**
     * FeaturedVideoController constructor.
     *
     * @param Video $videoModel
     */
    public function __construct(Video $videoModel)
    {
        $this->videoModel = $videoModel;
    }

    public function index()
    {
        $videos = $this->videoModel->with(['actors', 'owner'])->featured()->paginate(25);

        return VideoResource::collection($videos);
    }
}
