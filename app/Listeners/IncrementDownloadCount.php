<?php

namespace App\Listeners;

use App\DigitalBook;

class IncrementDownloadCount
{
    protected $bookModel;

    /**
     * Create the event listener.
     *
     * @param DigitalBook $bookModel
     */
    public function __construct(DigitalBook $bookModel)
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

        $book->increment('download_count');
    }
}
