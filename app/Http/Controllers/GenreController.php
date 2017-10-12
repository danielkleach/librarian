<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Http\Requests\GenreRequest;
use App\Http\Resources\Genre as GenreResource;

class GenreController extends Controller
{
    protected $genreModel;

    /**
     * GenreController constructor.
     *
     * @param Genre $genreModel
     */
    public function __construct(Genre $genreModel)
    {
        $this->genreModel = $genreModel;
    }

    public function index()
    {
        $categories = $this->genreModel->paginate(25);

        return GenreResource::collection($categories);
    }

    public function show($genreId)
    {
        $genre = $this->genreModel->with('videos')->findOrFail($genreId);

        return new GenreResource($genre);
    }

    public function store(GenreRequest $request)
    {
        $genre = $this->genreModel->create($request->all());

        return new GenreResource($genre);
    }

    public function update(GenreRequest $request, $genreId)
    {
        $genre = $this->genreModel->findOrFail($genreId);
        $genre->update($request->all());

        return new GenreResource($genre);
    }
}
