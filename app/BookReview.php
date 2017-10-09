<?php

namespace App;

use App\Events\BookRated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exceptions\UserAlreadyReviewedException;

class BookReview extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A BookReview belongs to a User.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A BookReview belongs to a Book.
     *
     * @return mixed
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    /**
     * A BookReview belongs to a DigitalBook.
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
     * Create a book review.
     *
     * @param $request
     * @param $user
     * @param $book
     * @return $this|Model
     * @throws UserAlreadyReviewedException
     * @internal param $bookId
     */
    public function createReview($request, $user, $book)
    {
        $review = $this->where('user_id', $user->id)->first();
        if ($review) {
            throw new UserAlreadyReviewedException;
        }

        $review = $this->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rating' => $request->rating,
            'comments' => $request->comments
        ]);

        event(new BookRated($review));

        return $review;
    }

    /**
     * Update a book review.
     *
     * @param $request
     * @param $review
     * @return $this|Model
     * @internal param $user
     * @internal param $book
     * @internal param $bookId
     */
    public function updateReview($request, $review)
    {
        $review->update($request->all());

        event(new BookRated($review));

        return $review;
    }
}
