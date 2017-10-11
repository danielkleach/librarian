<?php

namespace App;

use App\Traits\Ratable;
use Spatie\Tags\HasTags;
use App\Traits\Reviewable;
use App\Traits\Featurable;
use App\Traits\Favoritable;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Ebook extends Model implements HasMedia
{
    use SoftDeletes,
        Favoritable,
        Featurable,
        HasMediaTrait,
        HasTags,
        Ratable,
        Reviewable,
        Searchable;

    private $cacheCoverImage;

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
            'ebook_authors',
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

    /***********************************************/
    /******************* Scopes ********************/
    /***********************************************/

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
