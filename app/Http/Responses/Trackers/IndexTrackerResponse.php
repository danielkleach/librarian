<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        return response()->json($this->transformTrackers(), 200);
    }

    protected function transformTrackers()
    {
        return $this->trackers->map(function ($tracker) {
            return [
                'id' => (int) $tracker->id,
                'user_id' => (int) $tracker->user_id,
                'user_name' => $tracker->user->first_name,
                'book_id' => (int) $tracker->book_id,
                'book_title' => $tracker->book->title,
                'checkout_date' => Carbon::createFromFormat('Y-m-d H:i:s', $tracker->checkout_date)
                    ->toDateTimeString(),
                'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $tracker->due_date)
                    ->toDateTimeString(),
                'return_date' => $tracker->return_date
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $tracker->return_date)
                        ->toDateTimeString()
                    : null
            ];
        });
    }
}
