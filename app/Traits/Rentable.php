<?php

namespace App\Traits;

use App\User;
use App\Rental;

trait Rentable
{
    public function rentals()
    {
        return $this->morphMany(Rental::class, 'rentable');
    }

    public function scopeWhereRentedBy($query, User $user)
    {
        return $query->whereHas('rentals', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function isRentedBy(User $user)
    {
        return $this->rentals()->where('user_id', $user->id)->get();
    }

    public function rent()
    {
        $this->rentals()->save(
            new Rental(['user_id' => auth()->id()])
        );
    }
}