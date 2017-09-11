<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $guarded = [];

    protected $dates = [
        'checkout_date',
        'due_date',
        'return_date'
    ];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A Rental belongs to a User.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A Rental belongs to a Book.
     *
     * @return mixed
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
