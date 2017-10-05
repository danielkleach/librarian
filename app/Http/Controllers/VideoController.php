<?php

namespace App\Http\Controllers;

use App\Video;
use App\Actor;
use App\Http\Requests\VideoRequest;
use App\Http\Resources\Video as VideoResource;

class VideoController extends Controller
{
    protected $videoModel, $actorModel;

    /**
     * VideoController constructor.
     *
     * @param Video $videoModel
     * @param Actor $actorModel
     */
    public function __construct(Video $videoModel, Actor $actorModel)
    {
        $this->videoModel = $videoModel;
        $this->actorModel = $actorModel;
    }

    public function index()
    {
        return VideoResource::collection($this->videoModel
            ->with(['actors'])->paginate(25));
    }

    public function show($videoId)
    {
        return new VideoResource($this->videoModel
            ->with(['actors', 'owner'])->findOrFail($videoId));
    }

    public function store(VideoRequest $request)
    {
        $this->authorize('store', $this->videoModel);

        $video = $this->videoModel->create($request->all());

        return new VideoResource($video);
    }

    public function update(VideoRequest $request, $videoId)
    {
        $video = $this->videoModel->find($videoId);
        $this->authorize('update', $video);

        $video->update($request->all());

        return new VideoResource($video);
    }
}
