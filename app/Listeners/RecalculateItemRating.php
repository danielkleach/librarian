<?php

namespace App\Listeners;

use App\Review;

class RecalculateItemRating
{
    private $reviewModel;

    /**
     * Create the event listener.
     *
     * @param Review $reviewModel
     */
    public function __construct(Review $reviewModel)
    {
        $this->reviewModel = $reviewModel;
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        $item = $event->itemType->find($event->itemId);
        $rating = $this->reviewModel->where('reviewable_id', $item->id)->avg('rating');

        $item->rating = $rating;
        $item->save();
    }
}
