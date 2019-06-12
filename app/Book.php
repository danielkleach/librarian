<?php

namespace App;

use App\Traits\Ratable;
use App\Traits\Rentable;
use Spatie\Tags\HasTags;
use App\Traits\Reviewable;
use App\Traits\Featurable;
use App\Traits\Favoritable;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Book as BookResource;
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
        Ratable,
        Rentable,
        Reviewable,
        Searchable;

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

    /**
     * A Book belongs to a Category.
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
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
     * Get featured books.
     */
    public function getFeatured()
    {
        $books = $this->with(['authors', 'owner', 'category'])->featured()->paginate(25);

        return BookResource::collection($books);
    }

    /**
     * Get new books.
     */
    public function getNew()
    {
        $books = $this->with(['authors', 'owner', 'category'])->latest()->paginate(25);

        return BookResource::collection($books);
    }

    /**
     * Get popular books.
     */
    public function getPopular()
    {
        $books = $this->with(['authors', 'owner', 'category'])->popular()->paginate(25);

        return BookResource::collection($books);
    }

    /**
     * Get recommended books.
     */
    public function getRecommended()
    {
        $books = $this->with(['authors', 'owner', 'category'])->recommended()->paginate(25);

        return BookResource::collection($books);
    }
}
