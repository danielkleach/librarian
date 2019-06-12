<?php

namespace App\Http\Responses\Actors;

use Illuminate\Contracts\Support\Responsable;

class DestroyActorResponse implements Responsable
{
    protected $actor;

    public function __construct($actor)
    {
        $this->actor = $actor;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This actor has been deleted.'], 200);
    }
}
