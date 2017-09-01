<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;

class StoreUserResponse implements Responsable
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function toResponse($request)
    {
        return response()->json($this->transformUser(), 201);
    }

    protected function transformUser()
    {
        return [
            'id' => (int) $this->user->id,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'checked_out' => $this->user->getCheckedOut(),
            'overdue' => $this->user->getOverdue()
        ];
    }
}
