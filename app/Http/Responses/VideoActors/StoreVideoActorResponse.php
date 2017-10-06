<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class StoreVideoActorResponse implements Responsable
{
    public function toResponse($request)
    {
        return response()->json(['message' => 'This actor has been added to the video.'], 201);
    }
}
