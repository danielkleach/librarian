<?php

namespace App\Policies;

use App\User;
use App\Review;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    protected $reviewModel;

    /**
     * ReviewPolicy constructor.
     *
     * @param Review $reviewModel
     */
    public function __construct(Review $reviewModel)
    {
        $this->reviewModel = $reviewModel;
    }

    /**
     * Policy applying to updating a Review.
     *
     * @param User $user
     * @param Review $review
     * @return bool
     * @internal param Review $review
     */
    public function update(User $user, Review $review)
    {
        if ($user->id !== $review->user_id) {
            return false;
        }

        return true;
    }

    /**
     * Policy applying to destroying a Review.
     *
     * @param User $user
     * @param Review $review
     * @return bool
     * @internal param Review $review
     */
    public function destroy(User $user, Review $review)
    {
        if ($user->id !== $review->user_id) {
            return false;
        }

        return true;
    }
}
