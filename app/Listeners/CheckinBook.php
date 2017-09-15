<?php

namespace App\Listeners;

use App\Book;

class CheckinBook
{
    protected $bookModel;

    /**
     * Create the event listener.
     *
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        $this->bookModel = $bookModel;
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

        $book->status = 'available';
        $book->save();
    }
}
