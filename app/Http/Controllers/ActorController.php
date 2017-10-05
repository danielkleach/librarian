<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Http\Requests\ActorRequest;
use App\Http\Resources\Actor as ActorResource;

class ActorController extends Controller
{
    protected $actorModel;

    /**
     * ActorController constructor.
     *
     * @param Actor $actorModel
     */
    public function __construct(Actor $actorModel)
    {
        $this->actorModel = $actorModel;
    }

    public function index()
    {
        return ActorResource::collection($this->actorModel->paginate(25));
    }

    public function show($actorId)
    {
        return new ActorResource($this->actorModel->with('videos')->findOrFail($actorId));
    }

    public function store(ActorRequest $request)
    {
        return new ActorResource($this->actorModel->create($request->all()));
    }

    public function update(ActorRequest $request, $actorId)
    {
        $actor = $this->actorModel->findOrFail($actorId);
        $actor->update($request->all());

        return new ActorResource($actor);
    }

    public function destroy($actorId)
    {
        $actor = $this->actorModel->findOrFail($actorId);

        $actor->videos()->detach();
        $actor->delete();

        return new DestroyActorResponse($actor);
    }
}
