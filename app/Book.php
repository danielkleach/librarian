<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Book extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    private $cacheCoverImage;

    protected $fillable = [
        'category_id',
        'owner_id',
        'title',
        'description',
        'isbn',
        'publication_year',
        'location',
        'cover_image_url'
    ];

    protected $attributes = [
        'status' => 'available'
    ];

    protected $casts = [
        'featured' => 'boolean'
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
     * A Book belongs to a Category.
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
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
     * A Book has many Rentals.
     *
     * @return mixed
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class, 'book_id');
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
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include unavailable books.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnavailable($query)
    {
        return $query->where('status', 'unavailable');
    }

    /**
     * Scope a query to only include lost books.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLost($query)
    {
        return $query->where('status', 'lost');
    }

    /**
     * Scope a query to only include removed books.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRemoved($query)
    {
        return $query->where('status', 'removed');
    }

    /**
     * Scope a query to only include overdue books.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'available')
            ->whereHas('rentals', function ($query) {
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
}
