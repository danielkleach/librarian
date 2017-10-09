<?php

namespace App;

use App\Events\BookRated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exceptions\UserAlreadyReviewedException;

class Review extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A Review belongs to a User.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the owning reviewable models.
     */
    public function reviewable()
    {
        return $this->morphTo();
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Create a review.
     *
     * @param $request
     * @param $user
     * @param $item
     * @return $this|Model
     * @throws UserAlreadyReviewedException
     * @internal param $bookId
     */
    public function createReview($request, $user, $item)
    {
        $review = $this->where('user_id', $user->id)->first();
        if ($review) {
            throw new UserAlreadyReviewedException;
        }

        $review = $this->create([
            'user_id' => $user->id,
            'reviewable_id' => $item->id,
            'reviewable_type' => get_class($item),
            'rating' => $request->rating,
            'comments' => $request->comments
        ]);

//        event(new BookRated($review));

        return $review;
    }

    /**
     * Update a review.
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

//        event(new BookRated($review));

        return $review;
    }
}
