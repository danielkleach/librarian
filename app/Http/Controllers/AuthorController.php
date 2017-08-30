<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected $authorModel;

    public function __construct(Author $authorModel)
    {
        $this->authorModel = $authorModel;
    }

    public function index()
    {
        $authors = $this->authorModel->paginate(25);

        return new IndexAuthorResponse($authors);
    }

    public function show($authorId)
    {
        $author = $this->authorModel->findOrFail($authorId);

        return new ShowAuthorResponse($author);
    }

    public function store(Request $request)
    {
        $author = $this->authorModel->create($request->all());

        return new StoreAuthorResponse($author);
    }

    public function update(Request $request, $authorId)
    {
        $author = $this->authorModel->findOrFail($authorId);

        $author->update($request->all());

        return new UpdateAuthorResponse($author);
    }

    public function destroy($authorId)
    {
        $author = $this->authorModel->findOrFail($authorId);

        $author->delete();

        return new DestroyAuthorResponse($author);
    }
}
