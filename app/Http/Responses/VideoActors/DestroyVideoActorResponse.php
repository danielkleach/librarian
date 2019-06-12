<?php

namespace App\Http\Responses\VideoActors;

use Illuminate\Contracts\Support\Responsable;

class DestroyVideoActorResponse implements Responsable
{
    public function toResponse($request)
    {
        return response()->json(['message' => 'This actor has been removed from the video.'], 200);
    }
}
