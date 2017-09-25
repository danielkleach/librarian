<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Download extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A Download belongs to a User.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A Download belongs to a DigitalBook.
     *
     * @return mixed
     */
    public function digitalBook()
    {
        return $this->belongsTo(DigitalBook::class, 'book_id');
    }
}
