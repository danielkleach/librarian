<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A Book belongs to an Author.
     *
     * @return mixed
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * A Book belongs to a Category.
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
