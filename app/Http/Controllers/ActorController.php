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
        $actors = $this->actorModel->paginate(25);

        return ActorResource::collection($actors);
    }

    public function show($actorId)
    {
        $actor = $this->actorModel->with('videos')->findOrFail($actorId);

        return new ActorResource($actor);
    }

    public function store(ActorRequest $request)
    {
        $actor = $this->actorModel->create($request->all());

        return new ActorResource($actor);
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
