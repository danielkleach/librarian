<?php

namespace App\Events;

use App\BookReview;
use Illuminate\Queue\SerializesModels;

class BookRated
{
    use SerializesModels;

    public $bookId;

    /**
     * Create a new event instance.
     *
     * @param BookReview $bookReview
     * @internal param UserReview $bookReviewModel
     */
    public function __construct(BookReview $bookReview)
    {
        $this->bookId = $bookReview->book_id;
    }
}
