<?php

namespace App;

use Spatie\Tags\HasTags;
use App\Traits\Rentable;
use App\Traits\Featurable;
use App\Traits\Reviewable;
use App\Traits\Favoritable;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Rentable,
        Favoritable,
        Featurable,
        HasTags,
        Reviewable,
        Searchable;

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

    protected $indexConfigurator = VideoIndexConfigurator::class;
    protected $searchRules = [VideoSearchRule::class];
    protected $mapping = [
        'properties' => [
            'title' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'description' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'release_date' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'runtime' => [
                'type' => 'keyword'
            ]
        ]
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

    /***********************************************/
    /******************* Scopes ********************/
    /***********************************************/

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
