<?php

namespace App\Policies;

use App\User;
use App\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    protected $bookModel;

    /**
     * Policy applying to adding a Book.
     *
     * @param User $user
     * @param Book $book
     * @return bool
     */
    public function store(User $user, Book $book)
    {
        return $user->is_admin;
    }

    /**
     * Policy applying to updating a Book.
     *
     * @param User $user
     * @param Book $book
     * @return bool
     */
    public function update(User $user, Book $book)
    {
        return $user->is_admin;
    }
}
