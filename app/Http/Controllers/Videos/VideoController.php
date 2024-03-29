<?php

namespace App\Http\Controllers\Videos;

use App\Video;
use App\Actor;
use App\CreateVideo;
use App\Http\Requests\VideoRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video as VideoResource;

class VideoController extends Controller
{
    protected $videoModel, $actorModel, $createVideo;

    /**
     * VideoController constructor.
     *
     * @param Video $videoModel
     * @param Actor $actorModel
     * @param CreateVideo $createVideo
     */
    public function __construct(Video $videoModel, Actor $actorModel, CreateVideo $createVideo)
    {
        $this->videoModel = $videoModel;
        $this->actorModel = $actorModel;
        $this->createVideo = $createVideo;
    }

    public function index()
    {
        $videos = $this->videoModel->with(['actors', 'genre'])->paginate(25);

        return VideoResource::collection($videos);
    }

    public function show($videoId)
    {
        $video = $this->videoModel->with(['actors', 'genre', 'owner'])->findOrFail($videoId);

        return new VideoResource($video);
    }

    public function store(VideoRequest $request)
    {
        $this->authorize('store', $this->videoModel);

        $request = $request->all();
        $video = $this->createVideo->handle($request);

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
