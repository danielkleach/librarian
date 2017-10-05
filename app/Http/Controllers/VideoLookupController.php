<?php

namespace App\Http\Controllers;

use App\Video;
use App\VideoLookup;
use Illuminate\Http\Request;
use App\Http\Resources\Video as VideoResource;

class VideoLookupController extends Controller
{
    protected $lookup, $videoModel;

    /**
     * VideoLookupController constructor.
     *
     * @param VideoLookup $lookup
     * @param Video $videoModel
     */
    public function __construct(VideoLookup $lookup, Video $videoModel)
    {
        $this->lookup = $lookup;
        $this->videoModel = $videoModel;
    }

    public function index(Request $request)
    {
        $response = $this->lookup->search($request->term);

        return $response;
    }

    public function store(Request $request)
    {
        $response = $this->lookup->get($request->id);

        $video = $this->videoModel->create($response);

        return new VideoResource($video);
    }
}
