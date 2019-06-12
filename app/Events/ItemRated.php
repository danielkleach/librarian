<?php

namespace App\Events;

use App\Review;
use Illuminate\Queue\SerializesModels;

class ItemRated
{
    use SerializesModels;

    public $itemId;

    /**
     * Create a new event instance.
     *
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->itemId = $review->reviewable_id;
        $this->itemType = new $review->reviewable_type;
    }
}
