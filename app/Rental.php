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
        if (!$book->isAvailable()) {
            throw new BookUnavailableException;
        }

        $rental = $this->create([
            'user_id' => $user->id,
            'rentable_id' => $book->id,
            'rentable_type' => get_class($book),
            'checkout_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addDays(config('settings.rental_period'))
                ->toDateTimeString()
        ]);

        $book->checkedOut();

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
        if ($book->isAvailable()) {
            throw new BookAlreadyCheckedInException;
        }

        $this->update([
            'return_date' => Carbon::now()->toDateTimeString()
        ]);

        return $this;
    }
}
