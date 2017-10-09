<?php

namespace App\Traits;

use App\User;
use App\Review;

trait Reviewable
{
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function scopeWhereReviewedBy($query, User $user)
    {
        return $query->whereHas('reviews', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function isReviewedBy(User $user)
    {
        return $this->reviews()->where('user_id', $user->id)->get();
    }

    public function review()
    {
        $this->reviews()->save(
            new Review(['user_id' => auth()->id()])
        );
    }
}