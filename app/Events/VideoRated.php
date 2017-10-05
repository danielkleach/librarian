<?php

namespace App\Events;

use App\VideoReview;
use Illuminate\Queue\SerializesModels;

class VideoRated
{
    use SerializesModels;

    public $videoId;

    /**
     * Create a new event instance.
     *
     * @param VideoReview $videoReview
     * @internal param UserReview $videoReviewModel
     */
    public function __construct(VideoReview $videoReview)
    {
        $this->videoId = $videoReview->video_id;
    }
}
