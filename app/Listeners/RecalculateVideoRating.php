<?php

namespace App\Listeners;

use App\Video;
use App\VideoReview;

class RecalculateVideoRating
{
    private $videoModel;
    private $videoReviewModel;

    /**
     * Create the event listener.
     *
     * @param Video $videoModel
     * @param VideoReview $videoReviewModel
     */
    public function __construct(Video $videoModel, VideoReview $videoReviewModel)
    {
        $this->videoModel = $videoModel;
        $this->videoReviewModel = $videoReviewModel;
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        $video = $this->videoModel->find($event->videoId);
        $rating = $this->videoReviewModel->where('video_id', $video->id)->avg('rating');

        $video->rating = $rating;
        $video->save();
    }
}
