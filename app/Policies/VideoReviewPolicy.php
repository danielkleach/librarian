<?php

namespace App\Policies;

use App\User;
use App\VideoReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoReviewPolicy
{
    use HandlesAuthorization;

    protected $videoReviewModel;

    /**
     * VideoReviewPolicy constructor.
     *
     * @param VideoReview $videoReviewModel
     */
    public function __construct(VideoReview $videoReviewModel)
    {
        $this->videoReviewModel = $videoReviewModel;
    }

    /**
     * Policy applying to updating a VideoReview.
     *
     * @param User $user
     * @param VideoReview $videoReview
     * @return bool
     */
    public function update(User $user, VideoReview $videoReview)
    {
        if ($user->id !== $videoReview->user_id) {
            return false;
        }

        return true;
    }

    /**
     * Policy applying to destroying a VideoReview.
     *
     * @param User $user
     * @param VideoReview $videoReview
     * @return bool
     */
    public function destroy(User $user, VideoReview $videoReview)
    {
        if ($user->id !== $videoReview->user_id) {
            return false;
        }

        return true;
    }
}
