<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class StoreAuthorResponse implements Responsable
{
    protected $author;

    public function __construct($author)
    {
        $this->author = $author;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformAuthor(), 201);
    }

    protected function transformAuthor()
    {
        return [
            'id' => (int) $this->author->id,
            'name' => $this->author->name
        ];
    }
}
