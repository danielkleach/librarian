<?php

namespace App\Listeners;

use App\Book;
use App\BookReview;

class RecalculateBookRating
{
    private $bookModel;
    private $bookReviewModel;

    /**
     * Create the event listener.
     *
     * @param Book $bookModel
     * @param BookReview $bookReviewModel
     */
    public function __construct(Book $bookModel, BookReview $bookReviewModel)
    {
        $this->bookModel = $bookModel;
        $this->bookReviewModel = $bookReviewModel;
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
        $rating = $this->bookReviewModel->where('book_id', $book->id)->avg('rating');

        $book->rating = $rating;
        $book->save();
    }
}
