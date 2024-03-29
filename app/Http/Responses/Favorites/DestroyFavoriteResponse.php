<?php

namespace App\Http\Responses\Favorites;

use Illuminate\Contracts\Support\Responsable;

class DestroyFavoriteResponse implements Responsable
{
    public function toResponse($request)
    {
        return response()->json(['message' => 'This favorite has been deleted.'], 200);
    }
}
