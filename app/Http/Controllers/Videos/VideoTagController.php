<?php

namespace App\Http\Controllers\Videos;

use App\Video;
use Spatie\Tags\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoTagRequest;
use App\Http\Responses\VideoTags\StoreVideoTagResponse;
use App\Http\Responses\VideoTags\DestroyVideoTagResponse;

class VideoTagController extends Controller
{
    protected $videoModel, $tagModel;

    /**
     * VideoTagController constructor.
     *
     * @param Video $videoModel
     * @param Tag $tagModel
     */
    public function __construct(Video $videoModel, Tag $tagModel)
    {
        $this->videoModel = $videoModel;
        $this->tagModel = $tagModel;
    }

    public function store(VideoTagRequest $request, $videoId)
    {
        $video = $this->videoModel->findOrFail($videoId);
        $tag = $this->tagModel->findOrCreate($request->tag);

        $video->attachTag($tag);

        return new StoreVideoTagResponse($video);
    }

    public function destroy($videoId, $tag)
    {
        $video = $this->videoModel->findOrFail($videoId);

        $video->detachTag($tag);

        return new DestroyVideoTagResponse($video);
    }
}
