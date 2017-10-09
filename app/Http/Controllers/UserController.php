<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    protected $userModel;

    /**
     * UserController constructor.
     *
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function index()
    {
        $users = $this->userModel->paginate(25);

        return UserResource::collection($users);
    }

    public function show($userId)
    {
        $user = $this->userModel
            ->with(['reviews', 'rentals', 'favorites'])
            ->findOrFail($userId);

        return new UserResource($user);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userModel->create($request->all());

        return new UserResource($user);
    }

    public function update(UserRequest $request, $userId)
    {
        $user = $this->userModel->findOrFail($userId);
        $user->update($request->all());

        return new UserResource($user);
    }
}
