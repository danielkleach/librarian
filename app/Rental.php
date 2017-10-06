<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ItemUnavailableException;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exceptions\ItemAlreadyCheckedInException;

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
     * Get all of the owning rentable models.
     */
    public function rentable()
    {
        return $this->morphTo();
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Checkout an item.
     *
     * @param $user
     * @param $item
     * @return $this|Model
     * @throws ItemUnavailableException
     * @internal param $itemId
     */
    public function checkout($user, $item)
    {
        if (!$item->isAvailable()) {
            throw new ItemUnavailableException;
        }

        $rental = $this->create([
            'user_id' => $user->id,
            'rentable_id' => $item->id,
            'rentable_type' => get_class($item),
            'checkout_date' => Carbon::now()->toDateTimeString(),
            'due_date' => Carbon::now()->addDays(config('settings.rental_period'))
                ->toDateTimeString()
        ]);

        $item->checkedOut();

        return $rental;
    }

    /**
     * Checkin a item.
     *
     * @param $item
     * @return $this|Model
     * @throws ItemAlreadyCheckedInException
     */
    public function checkin($item)
    {
        if ($item->isAvailable()) {
            throw new ItemAlreadyCheckedInException;
        }

        $this->update([
            'return_date' => Carbon::now()->toDateTimeString()
        ]);

        return $this;
    }
}
