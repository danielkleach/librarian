<?php

namespace App\Policies;

use App\User;
use App\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    protected $videoModel;

    /**
     * Policy applying to adding a Video.
     *
     * @param User $user
     * @param Video $video
     * @return bool
     */
    public function store(User $user, Video $video)
    {
        return $user->is_admin;
    }

    /**
     * Policy applying to updating a Video.
     *
     * @param User $user
     * @param Video $video
     * @return bool
     */
    public function update(User $user, Video $video)
    {
        return $user->is_admin;
    }
}
