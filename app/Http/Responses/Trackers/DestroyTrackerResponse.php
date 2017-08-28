<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class DestroyTrackerResponse implements Responsable
{
    protected $tracker;

    public function __construct($tracker)
    {
        $this->tracker = $tracker;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This tracker has been deleted.']);
    }
}
