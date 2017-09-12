<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Checkout a book.
     *
     * @param $bookId
     * @return $this|Model
     */
    public function checkout($bookId)
    {
        $rental = $this->create([
            'user_id' => Auth::user()->id,
            'book_id' => $bookId,
            'checkout_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addDays(config('settings.rental_period'))
                ->toDateTimeString()
        ]);

        return $rental;
    }

    /**
     * Checkin a book.
     *
     * @return $this|Model
     */
    public function checkin()
    {
        $this->update([
            'return_date' => Carbon::now()->toDateTimeString()
        ]);

        return $this;
    }
}
