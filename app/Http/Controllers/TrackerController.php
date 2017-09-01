<?php

namespace App\Http\Controllers;

use App\Tracker;

class TrackerController extends Controller
{
    protected $trackerModel;

    public function __construct(Tracker $trackerModel)
    {
        $this->trackerModel = $trackerModel;
    }

    public function destroy($trackerId)
    {
        $tracker = $this->trackerModel->findOrFail($trackerId);

        $tracker->delete();

        return new DestroyTrackerResponse($tracker);
    }
}
