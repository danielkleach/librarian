<?php

namespace App\Http\Controllers;

use App\Tracker;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookCheckinController extends Controller
{
    protected $trackerModel;

    public function __construct(Tracker $trackerModel)
    {
        $this->trackerModel = $trackerModel;
    }

    public function store(Request $request)
    {
        $tracker = $this->trackerModel
            ->where('user_id', '=', $request->user_id)
            ->where('book_id', '=', $request->book_id)
            ->whereNull('return_date')
            ->firstOrFail();

        $tracker->update([
            'return_date' => Carbon::now()->toDateTimeString(),
        ]);

        return new UpdateTrackerResponse($tracker);
    }
}
