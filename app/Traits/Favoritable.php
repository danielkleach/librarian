<?php

namespace App\Traits;

use App\User;
use App\Favorite;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function scopeWhereFavoritedBy($query, User $user)
    {
        return $query->whereHas('favorites', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->get();
    }

    public function favorite()
    {
        $this->favorites()->save(
            new Favorite(['user_id' => auth()->id()])
        );
    }
}