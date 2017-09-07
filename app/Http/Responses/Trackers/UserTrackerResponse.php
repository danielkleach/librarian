<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;

class UserTrackerResponse implements Responsable
{
    protected $trackers;

    public function __construct($trackers)
    {
        $this->trackers = $trackers;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformTracker(), 200);
    }

    protected function transformTracker()
    {
        return $this->trackers->map(function ($tracker) {
            return [
                'id' => (int) $tracker->id,
                'user_id' => (int) $tracker->user_id,
                'book_id' => (int) $tracker->book_id,
                'book_title' => $tracker->book->title,
                'book_description' => $tracker->book->description,
                'category_id' => (int) $tracker->book->category_id,
                'category_name' => $tracker->book->category->name,
                'author_id' => (int) $tracker->book->author_id,
                'author_name' => $tracker->book->author->name,
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
