<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * An Author has many Books.
     *
     * @return mixed
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }
}
