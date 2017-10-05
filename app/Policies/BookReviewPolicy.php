<?php

namespace App\Policies;

use App\User;
use App\BookReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookReviewPolicy
{
    use HandlesAuthorization;

    protected $bookReviewModel;

    /**
     * BookReviewPolicy constructor.
     *
     * @param BookReview $bookReviewModel
     */
    public function __construct(BookReview $bookReviewModel)
    {
        $this->bookReviewModel = $bookReviewModel;
    }

    /**
     * Policy applying to updating a BookReview.
     *
     * @param User $user
     * @param BookReview $bookReview
     * @return bool
     * @internal param BookReview $bookReview
     */
    public function update(User $user, BookReview $bookReview)
    {
        if ($user->id !== $bookReview->user_id) {
            return false;
        }

        return true;
    }

    /**
     * Policy applying to destroying a BookReview.
     *
     * @param User $user
     * @param BookReview $bookReview
     * @return bool
     * @internal param BookReview $bookReview
     */
    public function destroy(User $user, BookReview $bookReview)
    {
        if ($user->id !== $bookReview->user_id) {
            return false;
        }

        return true;
    }
}
