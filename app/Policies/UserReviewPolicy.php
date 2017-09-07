<?php

namespace App\Policies;

use App\User;
use App\UserReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserReviewPolicy
{
    use HandlesAuthorization;

    protected $userReviewModel;

    /**
     * UserReviewPolicy constructor.
     *
     * @param UserReview $userReviewModel
     */
    public function __construct(UserReview $userReviewModel)
    {
        $this->userReviewModel = $userReviewModel;
    }

    /**
     * Policy applying to updating a UserReview.
     *
     * @param User $user
     * @param UserReview $userReview
     * @return bool
     * @internal param UserReview $job
     */
    public function update(User $user, UserReview $userReview)
    {
        if ($user->id !== $userReview->user_id) {
            return false;
        }

        return true;
    }

    /**
     * Policy applying to destroying a UserReview.
     *
     * @param User $user
     * @param UserReview $userReview
     * @return bool
     * @internal param UserReview $job
     */
    public function destroy(User $user, UserReview $userReview)
    {
        if ($user->id !== $userReview->user_id) {
            return false;
        }

        return true;
    }
}
