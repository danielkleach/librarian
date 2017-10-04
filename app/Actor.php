<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = [];

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
}
