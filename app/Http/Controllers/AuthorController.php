<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\Author as AuthorResource;
use App\Http\Responses\Authors\DestroyAuthorResponse;

class AuthorController extends Controller
{
    protected $authorModel;

    /**
     * AuthorController constructor.
     *
     * @param Author $authorModel
     */
    public function __construct(Author $authorModel)
    {
        $this->authorModel = $authorModel;
    }

    public function index()
    {
        $authors = $this->authorModel->paginate(25);

        return AuthorResource::collection($authors);
    }

    public function show($authorId)
    {
        $author = $this->authorModel->with('books')->findOrFail($authorId);

        return new AuthorResource($author);
    }

    public function store(AuthorRequest $request)
    {
        $author = $this->authorModel->create($request->all());

        return new AuthorResource($author);
    }

    public function update(AuthorRequest $request, $authorId)
    {
        $author = $this->authorModel->findOrFail($authorId);
        $author->update($request->all());

        return new AuthorResource($author);
    }

    public function destroy($authorId)
    {
        $author = $this->authorModel->findOrFail($authorId);

        $author->books()->detach();
        $author->delete();

        return new DestroyAuthorResponse($author);
    }
}
