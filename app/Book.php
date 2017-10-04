<?php

namespace App;

use Carbon\Carbon;
use App\Traits\Rentable;
use Spatie\Tags\HasTags;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Book extends Model implements HasMedia
{
    use SoftDeletes, Rentable, HasMediaTrait, HasTags, Searchable;

    private $cacheCoverImage;
    protected $indexConfigurator = BookIndexConfigurator::class;

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

    protected $searchRules = [
        BookSearchRule::class
    ];

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

    /**
     * A Book has many UserReviews.
     *
     * @return mixed
     */
    public function userReviews()
    {
        return $this->hasMany(UserReview::class, 'book_id');
    }

    /**
     * A Book has many FavoriteBooks.
     *
     * @return mixed
     */
    public function favoriteBooks()
    {
        return $this->hasMany(FavoriteBook::class, 'book_id');
    }

    /***********************************************/
    /******************* Scopes ********************/
    /***********************************************/

    /**
     * Scope a query to only include available books.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->whereDoesntHave('rentals', function ($query) {
            $query->whereNull('return_date');
        });
    }

    /**
     * Scope a query to only include unavailable books.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnavailable($query)
    {
        return $query->whereHas('rentals', function ($query) {
            $query->whereNull('return_date');
        });
    }

    /**
     * Scope a query to only include overdue books.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->whereHas('rentals', function ($query) {
            $query->where('due_date', '<', Carbon::now()->toDateTimeString())
                ->whereNull('return_date');
        });
    }

    /**
     * Scope a query to only include featured books.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to newest books first.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNew($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to most popular books first.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->orderBy('total_rentals', 'desc');
    }

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
