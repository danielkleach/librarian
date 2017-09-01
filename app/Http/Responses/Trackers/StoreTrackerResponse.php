<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;

class StoreTrackerResponse implements Responsable
{
    protected $tracker;

    public function __construct($tracker)
    {
        $this->tracker = $tracker;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformTracker(), 201);
    }

    protected function transformTracker()
    {
        return [
            'id' => (int) $this->tracker->id,
            'user_id' => (int) $this->tracker->user_id,
            'book_id' => (int) $this->tracker->book_id,
            'checkout_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->tracker->checkout_date)
                ->toDateTimeString(),
            'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->tracker->due_date)
                ->toDateTimeString(),
            'return_date' => $this->tracker->return_date
                ? Carbon::createFromFormat('Y-m-d H:i:s', $this->tracker->return_date)
                    ->toDateTimeString()
                : null
        ];
    }
}
