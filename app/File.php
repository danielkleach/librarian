<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'book_id',
        'format',
        'path'
    ];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A File belongs to a DigitalBook.
     *
     * @return mixed
     */
    public function digitalBook()
    {
        return $this->belongsTo(DigitalBook::class, 'book_id');
    }
}
