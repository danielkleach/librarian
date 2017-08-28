<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class IndexUserResponse implements Responsable
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformUsers());
    }

    protected function transformUsers()
    {
        return $this->users->map(function ($user) {
            return [
                'id' => (int) $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email
            ];
        });
    }
}
