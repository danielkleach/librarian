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
        return $this->belongsToMany(
            Book::class,
            'book_authors',
            'author_id',
            'book_id'
        )->withTimestamps();
    }
}
