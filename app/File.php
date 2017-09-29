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
        'path',
        'filename'
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

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Add Files to a Book.
     *
     * @param $files
     * @param $book
     */
    public function addFiles($files, $book)
    {
        collect($files)->each(function ($file) use ($book) {
            $path = $file->move(storage_path() . '/files/' . $book->id, $book->id . '-' . $file->getClientOriginalName());
            $this->create([
                'book_id' => $book->id,
                'format' => $file->getClientOriginalExtension(),
                'path' => $path,
                'filename' => $file->getClientOriginalName()
            ]);
        });
    }
}
