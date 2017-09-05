<?php

namespace App\Http\Controllers;

use App\Tracker;
use Carbon\Carbon;
use App\Http\Requests\BookCheckinRequest;

class BookCheckinController extends Controller
{
    protected $trackerModel;

    public function __construct(Tracker $trackerModel)
    {
        $this->trackerModel = $trackerModel;
    }

    public function store(BookCheckinRequest $request, $bookId)
    {
        $tracker = $this->trackerModel
            ->where('user_id', '=', $request->user_id)
            ->where('book_id', '=', $bookId)
            ->whereNull('return_date')
            ->firstOrFail();

        $tracker->update([
            'return_date' => Carbon::now()->toDateTimeString(),
        ]);

        return new UpdateTrackerResponse($tracker);
    }
}
