<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class DestroyAuthorResponse implements Responsable
{
    protected $author;

    public function __construct($author)
    {
        $this->author = $author;
    }

    public function toResponse($request)
    {
        return response()->json(['message' => 'This author has been deleted.'], 200);
    }
}
