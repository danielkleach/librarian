<?php

namespace App\Http\Controllers;

use App\Tracker;
use Illuminate\Http\Request;

class TrackerController extends Controller
{
    protected $trackerModel;

    public function __construct(Tracker $trackerModel)
    {
        $this->trackerModel = $trackerModel;
    }

    public function index()
    {
        $categories = $this->trackerModel->paginate(25);

        return new IndexTrackerResponse($categories);
    }

    public function show($trackerId)
    {
        $tracker = $this->trackerModel->findOrFail($trackerId);

        return new ShowTrackerResponse($tracker);
    }

    public function store(Request $request)
    {
        $tracker = $this->trackerModel->create($request->all());

        return new StoreTrackerResponse($tracker);
    }

    public function update(Request $request, $trackerId)
    {
        $tracker = $this->trackerModel->findOrFail($trackerId);

        $tracker->update($request->all());

        return new UpdateTrackerResponse($tracker);
    }

    public function destroy($trackerId)
    {
        $tracker = $this->trackerModel->findOrFail($trackerId);

        $tracker->delete();

        return new DestroyTrackerResponse($tracker);
    }
}
