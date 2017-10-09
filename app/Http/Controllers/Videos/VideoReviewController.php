<?php

namespace App\Http\Controllers\Videos;

use App\Video;
use App\VideoReview;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoReviewRequest;
use App\Http\Resources\VideoReview as VideoReviewResource;
use App\Http\Responses\VideoReviews\DestroyVideoReviewResponse;

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
        $review = $this->videoReviewModel
            ->with(['user', 'video'])->findOrFail($videoReviewId);

        return new VideoReviewResource($review);
    }

    public function store(VideoReviewRequest $request, $videoId)
    {
        $user = Auth::user();
        $video = $this->videoModel->findOrFail($videoId);

        $review = $this->videoReviewModel->createReview($request, $user, $video);

        return new VideoReviewResource($review);
    }

    public function update(VideoReviewRequest $request, $videoReviewId)
    {
        $videoReview = $this->videoReviewModel->findOrFail($videoReviewId);
        $this->authorize('update', $videoReview);

        $review = $this->videoReviewModel->updateReview($request, $videoReview);

        return new VideoReviewResource($review);
    }

    public function destroy($videoReviewId)
    {
        $videoReview = $this->videoReviewModel->findOrFail($videoReviewId);
        $this->authorize('destroy', $videoReview);

        $videoReview->delete();

        return new DestroyVideoReviewResponse($videoReview);
    }
}
