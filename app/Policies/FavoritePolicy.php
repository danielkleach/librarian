<?php

namespace App\Policies;

use App\User;
use App\Favorite;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavoritePolicy
{
    use HandlesAuthorization;

    protected $favoriteModel;

    /**
     * FavoritePolicy constructor.
     *
     * @param Favorite $favoriteModel
     */
    public function __construct(Favorite $favoriteModel)
    {
        $this->favoriteModel = $favoriteModel;
    }

    /**
     * Policy applying to updating a Favorite.
     *
     * @param User $user
     * @param Favorite $favoriteModel
     * @return bool
     */
    public function update(User $user, Favorite $favoriteModel)
    {
        if ($user->id !== $favoriteModel->user_id) {
            return false;
        }

        return true;
    }

    /**
     * Policy applying to destroying a Favorite.
     *
     * @param User $user
     * @param Favorite $favoriteModel
     * @return bool
     */
    public function destroy(User $user, Favorite $favoriteModel)
    {
        if ($user->id !== $favoriteModel->user_id) {
            return false;
        }

        return true;
    }
}
