<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * An Actor has many Videos.
     *
     * @return mixed
     */
    public function videos()
    {
        return $this->belongsToMany(
            Video::class,
            'video_actors',
            'actor_id',
            'video_id'
        )->withTimestamps();
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Add Actors to a Video.
     *
     * @param $actors
     * @param $video
     */
    public function addActors($actors, $video)
    {
        collect($actors)->each(function($actorName) use ($video) {
            $actor = $this->firstOrCreate(['name' => $actorName]);
            $video->actors()->attach($actor);
        });
    }
}
