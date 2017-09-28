<?php

namespace App\Events;

use App\Download;
use Illuminate\Queue\SerializesModels;

class BookDownloaded
{
    use SerializesModels;

    public $bookId;

    /**
     * Create a new event instance.
     *
     * @param Download $download
     */
    public function __construct(Download $download)
    {
        $this->bookId = $download->book_id;
    }
}
