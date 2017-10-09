<?php

namespace App\Http\Controllers\Videos;

use App\Video;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoActorRequest;
use App\Http\Responses\VideoActors\StoreVideoActorResponse;
use App\Http\Responses\VideoActors\DestroyVideoActorResponse;

class VideoActorController extends Controller
{
    protected $videoModel;

    /**
     * VideoActorController constructor.
     *
     * @param Video $videoModel
     */
    public function __construct(Video $videoModel)
    {
        $this->videoModel = $videoModel;
    }

    public function store(VideoActorRequest $request, $videoId)
    {
        $video = $this->videoModel->findOrFail($videoId);

        $video->actors()->attach($request->actor_id);

        return new StoreVideoActorResponse($video);
    }

    public function destroy($videoId, $actorId)
    {
        $video = $this->videoModel->findOrFail($videoId);

        $video->actors()->detach($actorId);

        return new DestroyVideoActorResponse($video);
    }
}
