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
        return UserResource::collection($this->userModel->paginate(25));
    }

    public function show($userId)
    {
        return new UserResource($this->userModel
            ->with(['bookReviews.book', 'videoReviews.video', 'rentals.book.authors'])
            ->findOrFail($userId));
    }

    public function store(UserRequest $request)
    {
        return new UserResource($this->userModel->create($request->all()));
    }

    public function update(UserRequest $request, $userId)
    {
        $user = $this->userModel->findOrFail($userId);
        $user->update($request->all());

        return new UserResource($user);
    }
}
