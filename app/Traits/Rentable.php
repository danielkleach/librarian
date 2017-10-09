<?php

namespace App\Traits;

use App\User;
use App\Rental;
use Carbon\Carbon;

trait Rentable
{
    /**
     * Get rentals for an item.
     *
     * @return mixed
     */
    public function rentals()
    {
        return $this->morphMany(Rental::class, 'rentable');
    }

    /**
     * Get items rented by the user.
     *
     * @param User $user
     * @return mixed
     */
    public function isRentedBy(User $user)
    {
        return $this->rentals()->where('user_id', $user->id)->get();
    }

    /**
     * Rent an item.
     */
    public function rent()
    {
        $this->rentals()->save(
            new Rental(['user_id' => auth()->id()])
        );
    }

    /**
     * Scope a query to only include items rented by a specific user.
     *
     * @param $query
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereRentedBy($query, User $user)
    {
        return $query->whereHas('rentals', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    /**
     * Scope a query to only include available items.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->whereDoesntHave('rentals', function ($query) {
            $query->whereNull('return_date');
        });
    }

    /**
     * Scope a query to only include unavailable items.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnavailable($query)
    {
        return $query->whereHas('rentals', function ($query) {
            $query->whereNull('return_date');
        });
    }

    /**
     * Scope a query to only include overdue items.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->whereHas('rentals', function ($query) {
            $query->where('due_date', '<', Carbon::now()->toDateTimeString())
                ->whereNull('return_date');
        });
    }

    /**
     * Scope a query to most popular books first.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->orderBy('total_rentals', 'desc');
    }
}