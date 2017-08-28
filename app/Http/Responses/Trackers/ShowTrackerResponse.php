<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class ShowTrackerResponse implements Responsable
{
    protected $tracker;

    public function __construct($tracker)
    {
        $this->tracker = $tracker;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformTracker());
    }

    protected function transformTracker()
    {
        return [
            'id' => (int) $this->tracker->id,
            'user_id' => (int) $this->tracker->user_id,
            'book_id' => (int) $this->tracker->book_id,
            'checkout_date' => $this->tracker->checkout_date->toDateTimeString(),
            'due_date' => $this->tracker->due_date->toDateTimeString(),
            'return_date' => $this->tracker->return_date
                ? $this->tracker->return_date->toDateTimeString()
                : null
        ];
    }
}
