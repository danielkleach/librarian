<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * An Genre has many Videos.
     *
     * @return mixed
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'genre_id');
    }
}
