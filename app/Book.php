<?php

namespace App;

use App\Traits\Rentable;
use Spatie\Tags\HasTags;
use App\Traits\Reviewable;
use App\Traits\Featurable;
use App\Traits\Favoritable;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Book extends Model implements HasMedia
{
    use SoftDeletes,
        Favoritable,
        Featurable,
        HasMediaTrait,
        HasTags,
        Rentable,
        Reviewable,
        Searchable;

    private $cacheCoverImage;

    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'isbn',
        'publication_year',
        'location',
        'cover_image_url'
    ];

    protected $casts = [
        'featured' => 'boolean'
    ];

    protected $indexConfigurator = BookIndexConfigurator::class;
    protected $searchRules = [BookSearchRule::class];
    protected $mapping = [
        'properties' => [
            'title' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'description' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'isbn' => [
                'type' => 'keyword',
            ],
            'publication_year' => [
                'type' => 'text',
                'analyzer' => 'english'
            ]
        ]
    ];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A Book belongs to an Author.
     *
     * @return mixed
     */
    public function authors()
    {
        return $this->belongsToMany(
            Author::class,
            'book_authors',
            'book_id',
            'author_id'
        )->withTimestamps();
    }

    /**
     * A Book belongs to a User.
     *
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /***********************************************/
    /******************* Scopes ********************/
    /***********************************************/

    /**
     * Scope a query to best rated books first.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecommended($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Get the cover image.
     *
     * @return string
     */
    public function getCoverImageAttribute()
    {
        if ($this->cacheCoverImage) {
            return $this->cacheCoverImage;
        }

        return $this->cacheCoverImage = new CoverImage($this);
    }

    /**
     * Checks if the Book is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        $rented = $this->rentals()->whereNull('return_date')->first();

        return $rented ? false : true;
    }

    /**
     * Handle a Book checkout.
     *
     * @return bool
     */
    public function checkedOut()
    {
        $this->increment('total_rentals');

        return true;
    }
}
