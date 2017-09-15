<?php

namespace App;

use Carbon\Carbon;
use App\Events\BookRented;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use SoftDeletes;

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
     * @param $user
     * @param $book
     * @return $this|Model
     * @internal param $bookId
     */
    public function checkout($user, $book)
    {
        $rental = $this->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'checkout_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addDays(config('settings.rental_period'))
                ->toDateTimeString()
        ]);

        event(new BookRented($rental));

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

        event(new BookReturned($this));

        return $this;
    }
}
