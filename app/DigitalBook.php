<?php

namespace App;

use Spatie\Tags\HasTags;
use App\Traits\Favoritable;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class DigitalBook extends Model implements HasMedia
{
    use SoftDeletes, Favoritable, HasMediaTrait, HasTags, Searchable;

    private $cacheCoverImage;
    protected $indexConfigurator = BookIndexConfigurator::class;

    protected $fillable = [
        'title',
        'description',
        'isbn',
        'publication_year',
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
            'digital_book_authors',
            'book_id',
            'author_id'
        )->withTimestamps();
    }

    /**
     * A Book has many Downloads.
     *
     * @return mixed
     */
    public function downloads()
    {
        return $this->hasMany(Download::class, 'book_id');
    }

    /**
     * A Book has many Rentals.
     *
     * @return mixed
     */
    public function files()
    {
        return $this->hasMany(File::class, 'book_id');
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

    /***********************************************/
    /******************* Scopes ********************/
    /***********************************************/

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
        return $query->orderBy('download_count', 'desc');
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

    public function downloaded()
    {
        $this->increment('download_count');

        return true;
    }
}
