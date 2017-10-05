<?php

namespace App\Policies;

use App\User;
use App\FavoriteBook;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavoriteBookPolicy
{
    use HandlesAuthorization;

    protected $favoriteBookModel;

    /**
     * FavoriteBookPolicy constructor.
     *
     * @param FavoriteBook $favoriteBookModel
     */
    public function __construct(FavoriteBook $favoriteBookModel)
    {
        $this->favoriteBookModel = $favoriteBookModel;
    }

    /**
     * Policy applying to updating a FavoriteBook.
     *
     * @param User $user
     * @param FavoriteBook $favoriteBookModel
     * @return bool
     */
    public function update(User $user, FavoriteBook $favoriteBookModel)
    {
        if ($user->id !== $favoriteBookModel->user_id) {
            return false;
        }

        return true;
    }

    /**
     * Policy applying to destroying a FavoriteBook.
     *
     * @param User $user
     * @param FavoriteBook $favoriteBookModel
     * @return bool
     */
    public function destroy(User $user, FavoriteBook $favoriteBookModel)
    {
        if ($user->id !== $favoriteBookModel->user_id) {
            return false;
        }

        return true;
    }
}
