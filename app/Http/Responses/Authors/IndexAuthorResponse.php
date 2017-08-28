<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class IndexAuthorResponse implements Responsable
{
    protected $authors;

    public function __construct($authors)
    {
        $this->authors = $authors;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformAuthors());
    }

    protected function transformAuthors()
    {
        return $this->authors->map(function ($author) {
            return [
                'id' => (int) $author->id,
                'name' => $author->name
            ];
        });
    }
}
