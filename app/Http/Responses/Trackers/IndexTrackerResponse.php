<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class IndexTrackerResponse implements Responsable
{
    protected $trackers;

    public function __construct($trackers)
    {
        $this->trackers = $trackers;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformTrackers());
    }

    protected function transformTrackers()
    {
        return $this->trackers->map(function ($tracker) {
            return [
                'id' => (int) $tracker->id,
                'user_id' => (int) $tracker->user_id,
                'book_id' => (int) $tracker->book_id,
                'checkout_date' => $tracker->checkout_date,
                'due_date' => $tracker->due_date,
                'return_date' => $tracker->return_date
            ];
        });
    }
}
