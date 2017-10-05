<?php

namespace App\Http\Controllers;

use App\Video;
use App\VideoReview;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VideoReviewRequest;
use App\Http\Resources\VideoReview as VideoReviewResource;

class VideoReviewController extends Controller
{
    protected $videoModel, $videoReviewModel;

    /**
     * VideoReviewController constructor.
     *
     * @param Video $videoModel
     * @param VideoReview $videoReviewModel
     */
    public function __construct(Video $videoModel, VideoReview $videoReviewModel)
    {
        $this->videoModel = $videoModel;
        $this->videoReviewModel = $videoReviewModel;
    }

    public function show($videoReviewId)
    {
        return new VideoReviewResource($this->videoReviewModel
            ->with(['user', 'video'])->findOrFail($videoReviewId));
    }

    public function store(VideoReviewRequest $request, $videoId)
    {
        $user = Auth::user();
        $video = $this->videoModel->findOrFail($videoId);

        return new VideoReviewResource($this->videoReviewModel->createReview($request, $user, $video));
    }

    public function update(VideoReviewRequest $request, $videoReviewId)
    {
        $videoReview = $this->videoReviewModel->findOrFail($videoReviewId);
        $this->authorize('update', $videoReview);

        return new VideoReviewResource($this->videoReviewModel->updateReview($request, $videoReview));
    }

    public function destroy($videoReviewId)
    {
        $videoReview = $this->videoReviewModel->findOrFail($videoReviewId);
        $this->authorize('destroy', $videoReview);

        $videoReview->delete();

        return new DestroyVideoReviewResponse($videoReview);
    }
}
