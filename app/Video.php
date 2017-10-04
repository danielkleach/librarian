<?php

namespace App;

use App\Traits\Rentable;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Rentable;

    protected $guarded = [];

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
}
