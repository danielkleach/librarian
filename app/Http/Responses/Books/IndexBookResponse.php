<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class IndexBookResponse implements Responsable
{
    public function toResponse($request)
    {
        return [

        ];
    }
}
