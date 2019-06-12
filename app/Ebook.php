<?php

namespace App;

use App\Traits\Ratable;
use Spatie\Tags\HasTags;
use App\Traits\Reviewable;
use App\Traits\Featurable;
use App\Traits\Favoritable;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Ebook as BookResource;
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
        'category_id',
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
     * An Ebook belongs to an Author.
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
     * An Ebook belongs to a Category.
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * An Ebook has many Downloads.
     *
     * @return mixed
     */
    public function downloads()
    {
        return $this->hasMany(Download::class, 'book_id');
    }

    /**
     * An Ebook has many Rentals.
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

    /**
     * Increment the download_count when a book is downloaded.
     *
     * @return bool
     */
    public function downloaded()
    {
        $this->increment('download_count');

        return true;
    }

    /**
     * Get featured ebooks.
     */
    public function getFeatured()
    {
        $books = $this->with(['authors', 'category'])->featured()->paginate(25);

        return BookResource::collection($books);
    }

    /**
     * Get new ebooks.
     */
    public function getNew()
    {
        $books = $this->with(['authors', 'category'])->latest()->paginate(25);

        return BookResource::collection($books);
    }

    /**
     * Get popular ebooks.
     */
    public function getPopular()
    {
        $books = $this->with(['authors', 'category'])->popular()->paginate(25);

        return BookResource::collection($books);
    }

    /**
     * Get recommended ebooks.
     */
    public function getRecommended()
    {
        $books = $this->with(['authors', 'category'])->recommended()->paginate(25);

        return BookResource::collection($books);
    }
}
