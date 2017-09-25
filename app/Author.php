<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

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

    /**
     * An Author has many Books.
     *
     * @return mixed
     */
    public function digitalBooks()
    {
        return $this->belongsToMany(
            DigitalBook::class,
            'digital_book_authors',
            'author_id',
            'book_id'
        )->withTimestamps();
    }
}
