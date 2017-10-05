<?php

namespace App;

use Carbon\Carbon;
use Spatie\Tags\HasTags;
use App\Traits\Rentable;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Rentable, HasTags;

    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'release_date',
        'runtime',
        'thumbnail_path',
        'header_path',
        'location',
    ];

    protected $casts = [
        'featured' => 'boolean'
    ];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A Video belongs to an Actor.
     *
     * @return mixed
     */
    public function actors()
    {
        return $this->belongsToMany(
            Actor::class,
            'video_actors',
            'video_id',
            'actor_id'
        )->withTimestamps();
    }

    /**
     * A Video belongs to a User.
     *
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * A Video has many Reviews.
     *
     * @return mixed
     */
    public function reviews()
    {
        return $this->hasMany(VideoReview::class, 'video_id');
    }

    /***********************************************/
    /******************* Scopes ********************/
    /***********************************************/

    /**
     * Scope a query to only include available videos.
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
     * Scope a query to only include unavailable videos.
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
     * Scope a query to only include overdue videos.
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
     * Scope a query to only include featured videos.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to newest videos first.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNew($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to most popular videos first.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->orderBy('total_rentals', 'desc');
    }

    /**
     * Scope a query to best rated videos first.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecommended($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Checks if the Book is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        $rented = $this->rentals()->whereNull('return_date')->first();

        return $rented ? false : true;
    }

    /**
     * Handle a Book checkout.
     *
     * @return bool
     */
    public function checkedOut()
    {
        $this->increment('total_rentals');

        return true;
    }
}
