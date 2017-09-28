<?php

namespace App;

use App\Events\BookDownloaded;
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

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Download a digital book.
     *
     * @param $user
     * @param $bookId
     * @return $this|Model
     */
    public function download($user, $bookId)
    {
        $download = $this->create([
            'user_id' => $user->id,
            'book_id' => $bookId
        ]);

        event(new BookDownloaded($download));
    }
}
