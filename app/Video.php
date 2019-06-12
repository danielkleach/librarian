<?php

namespace App;

use App\Traits\Ratable;
use Spatie\Tags\HasTags;
use App\Traits\Rentable;
use App\Traits\Featurable;
use App\Traits\Reviewable;
use App\Traits\Favoritable;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Video as VideoResource;

class Video extends Model
{
    use Rentable,
        Favoritable,
        Featurable,
        HasTags,
        Ratable,
        Reviewable,
        Searchable;

    protected $fillable = [
        'genre_id',
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
     * A Video belongs to a Genre.
     *
     * @return mixed
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
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
     * Get featured videos.
     */
    public function getFeatured()
    {
        $videos = $this->with(['actors', 'owner'])->featured()->paginate(25);

        return VideoResource::collection($videos);
    }

    /**
     * Get new videos.
     */
    public function getNew()
    {
        $videos = $this->with(['actors', 'owner'])->latest()->paginate(25);

        return VideoResource::collection($videos);
    }

    /**
     * Get popular videos.
     */
    public function getPopular()
    {
        $videos = $this->with(['actors', 'owner'])->popular()->paginate(25);

        return VideoResource::collection($videos);
    }

    /**
     * Get recommended videos.
     */
    public function getRecommended()
    {
        $videos = $this->with(['actors', 'owner'])->recommended()->paginate(25);

        return VideoResource::collection($videos);
    }
}
