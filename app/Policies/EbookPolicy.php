<?php

namespace App\Policies;

use App\User;
use App\Ebook;
use Illuminate\Auth\Access\HandlesAuthorization;

class EbookPolicy
{
    use HandlesAuthorization;

    /**
     * Policy applying to adding a Book.
     *
     * @param User $user
     * @param Ebook $book
     * @return bool
     */
    public function store(User $user, Ebook $book)
    {
        return $user->is_admin;
    }

    /**
     * Policy applying to updating a Book.
     *
     * @param User $user
     * @param Ebook $book
     * @return bool
     */
    public function update(User $user, Ebook $book)
    {
        return $user->is_admin;
    }
}
