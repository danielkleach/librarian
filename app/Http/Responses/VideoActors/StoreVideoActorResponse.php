<?php

namespace App\Http\Responses\VideoActors;

use Illuminate\Contracts\Support\Responsable;

class StoreVideoActorResponse implements Responsable
{
    public function toResponse($request)
    {
        return response()->json(['message' => 'This actor has been added to the video.'], 201);
    }
}
