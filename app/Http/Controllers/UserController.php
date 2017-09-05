<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function index()
    {
        $users = $this->userModel->paginate(25);

        return new IndexUserResponse($users);
    }

    public function show($userId)
    {
        $user = $this->userModel->with(['userReviews.book', 'trackers.book'])->findOrFail($userId);

        return new ShowUserResponse($user);
    }

    public function store(UserRequest $request)
    {
        $user = $this->userModel->create($request->all());

        return new StoreUserResponse($user);
    }

    public function update(UserRequest $request, $userId)
    {
        $user = $this->userModel->findOrFail($userId);

        $user->update($request->all());

        return new UpdateUserResponse($user);
    }

    public function destroy($userId)
    {
        $user = $this->userModel->findOrFail($userId);

        $user->delete();

        return new DestroyUserResponse($user);
    }
}
