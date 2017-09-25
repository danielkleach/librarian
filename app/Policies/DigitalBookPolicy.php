<?php

namespace App\Policies;

use App\User;
use App\DigitalBook;
use Illuminate\Auth\Access\HandlesAuthorization;

class DigitalBookPolicy
{
    use HandlesAuthorization;

    protected $bookModel;

    /**
     * Policy applying to adding a Book.
     *
     * @param User $user
     * @param DigitalBook $book
     * @return bool
     * @internal param Book $job
     */
    public function store(User $user, DigitalBook $book)
    {
        return $user->isAdmin();
    }

    /**
     * Policy applying to updating a Book.
     *
     * @param User $user
     * @param DigitalBook $book
     * @return bool
     * @internal param Book $job
     */
    public function update(User $user, DigitalBook $book)
    {
        return $user->isAdmin();
    }
}
