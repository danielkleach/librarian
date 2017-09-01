<?php

namespace App\Http\Controllers;

use App\Tracker;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookCheckoutController extends Controller
{
    protected $trackerModel;

    public function __construct(Tracker $trackerModel)
    {
        $this->trackerModel = $trackerModel;
    }

    public function store(Request $request, $bookId)
    {
        $tracker = $this->trackerModel->create([
            'user_id' => $request->user_id,
            'book_id' => $bookId,
            'checkout_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addWeeks(2)->toDateTimeString()
        ]);

        return new StoreTrackerResponse($tracker);
    }
}
