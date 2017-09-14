<?php

namespace App\Listeners;

use App\Book;
use App\UserReview;

class RecalculateBookRating
{
    private $bookModel;
    private $userReviewModel;

    /**
     * Create the event listener.
     *
     * @param Book $bookModel
     * @param UserReview $userReviewModel
     */
    public function __construct(Book $bookModel, UserReview $userReviewModel)
    {
        $this->bookModel = $bookModel;
        $this->userReviewModel = $userReviewModel;
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        $book = $this->bookModel->find($event->bookId);
        $rating = $this->userReviewModel->where('book_id', $book->id)->avg('rating');

        $book->rating = $rating;
        $book->save();
    }
}
