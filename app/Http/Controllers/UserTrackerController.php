<?php

namespace App\Http\Controllers;

use App\Tracker;

class UserTrackerController extends Controller
{
    protected $trackerModel;

    public function __construct(Tracker $trackerModel)
    {
        $this->trackerModel = $trackerModel;
    }

    public function index($userId)
    {
        $tracker = $this->trackerModel->with(['book.category', 'book.author'])
            ->where('user_id', '=', $userId)->paginate(20);

        return new UserTrackerResponse($tracker);
    }
}
