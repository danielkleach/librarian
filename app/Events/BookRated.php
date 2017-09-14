<?php

namespace App\Events;

use App\UserReview;
use Illuminate\Queue\SerializesModels;

class BookRated
{
    use SerializesModels;

    public $bookId;

    /**
     * Create a new event instance.
     *
     * @param UserReview $userReview
     * @internal param UserReview $userReviewModel
     */
    public function __construct(UserReview $userReview)
    {
        $this->bookId = $userReview->book_id;
    }
}
