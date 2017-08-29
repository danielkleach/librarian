<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A User has many Trackers.
     *
     * @return mixed
     */
    public function trackers()
    {
        return $this->hasMany(Tracker::class, 'user_id');
    }

    /**
     * A User has many UserReviews.
     *
     * @return mixed
     */
    public function userReviews()
    {
        return $this->hasMany(UserReview::class, 'user_id');
    }
}
