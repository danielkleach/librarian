<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable;

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
     * A User has many Books.
     *
     * @return mixed
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'owner_id');
    }

    /**
     * A User has many Rentals.
     *
     * @return mixed
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class, 'user_id');
    }

    /**
     * A User has many videos.
     *
     * @return mixed
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'owner_id');
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

    /**
     * A User has many FavoriteBooks.
     *
     * @return mixed
     */
    public function favoriteBooks()
    {
        return $this->hasMany(FavoriteBook::class, 'user_id');
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Check if user has a role of admin.
     */
    public function isAdmin() {
        return $this->roles->where('slug', 'admin')->isNotEmpty();
    }

    /**
     * Generate an api token for the user.
     */
    public function generateToken()
    {
        $this->api_token = str_random(80);
        $this->save();
        return $this->api_token;
    }

    /**
     * Combine the user's first name and last name.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Determines what books this user currently has checked out.
     */
    public function getCheckedOut()
    {
        return $this->rentals->where('return_date', null);
    }

    /**
     * Determines what books this user currently has overdue.
     */
    public function getOverDue()
    {
        return $this->rentals->where('due_date', '<', Carbon::now()->toDateTimeString())
            ->where('return_date', null);
    }
}
