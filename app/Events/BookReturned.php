<?php

namespace App\Events;

use App\Rental;
use Illuminate\Queue\SerializesModels;

class BookReturned
{
    use SerializesModels;

    public $bookId;

    /**
     * Create a new event instance.
     *
     * @param Rental $rental
     */
    public function __construct(Rental $rental)
    {
        $this->bookId = $rental->book_id;
    }
}
