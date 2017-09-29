<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\Author as AuthorResource;

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
        return AuthorResource::collection($this->authorModel->paginate(25));
    }

    public function show($authorId)
    {
        return new AuthorResource($this->authorModel->with('books')->findOrFail($authorId));
    }

    public function store(AuthorRequest $request)
    {
        return new AuthorResource($this->authorModel->create($request->all()));
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
