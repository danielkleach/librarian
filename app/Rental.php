<?php

namespace App;

use Carbon\Carbon;
use App\Events\BookRented;
use App\Events\BookReturned;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\BookUnavailableException;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exceptions\BookAlreadyCheckedInException;

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
     * @throws BookUnavailableException
     * @internal param $bookId
     */
    public function checkout($user, $book)
    {
        if ($book->status != 'available') {
            throw new BookUnavailableException;
        }

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
     * @param $book
     * @return $this|Model
     * @throws BookAlreadyCheckedInException
     */
    public function checkin($book)
    {
        if ($book->status == 'available') {
            throw new BookAlreadyCheckedInException;
        }

        $this->update([
            'return_date' => Carbon::now()->toDateTimeString()
        ]);

        event(new BookReturned($this));

        return $this;
    }
}
