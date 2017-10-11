<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * An Category has many Books.
     *
     * @return mixed
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }

    /**
     * An Category has many Ebooks.
     *
     * @return mixed
     */
    public function ebooks()
    {
        return $this->hasMany(Ebook::class, 'category_id');
    }
}
