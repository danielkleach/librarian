<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class DestroyUserResponse implements Responsable
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This user has been deleted.'], 200);
    }
}
