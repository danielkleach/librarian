<?php

namespace App;

use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes, Searchable;

    protected $guarded = [];
    protected $indexConfigurator = BookIndexConfigurator::class;

    protected $searchRules = [
        BookSearchRule::class
    ];

    protected $mapping = [
        'properties' => [
            'id' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
            'name' => [
                'type' => 'string',
                'analyzer' => 'english'
            ],
        ]
    ];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * An Author has many Books.
     *
     * @return mixed
     */
    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'book_authors',
            'author_id',
            'book_id'
        )->withTimestamps();
    }

    /**
     * An Author has many Books.
     *
     * @return mixed
     */
    public function digitalBooks()
    {
        return $this->belongsToMany(
            DigitalBook::class,
            'digital_book_authors',
            'author_id',
            'book_id'
        )->withTimestamps();
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Add Authors to a Book.
     *
     * @param $authors
     * @param $book
     */
    public function addAuthors($authors, $book)
    {
        collect($authors)->each(function($authorName) use ($book) {
            $author = $this->firstOrCreate(['name' => $authorName]);
            $book->authors()->attach($author);
        });
    }
}
