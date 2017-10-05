<?php

namespace App;

use App\Events\VideoRated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exceptions\UserAlreadyReviewedException;

class VideoReview extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A VideoReview belongs to a User.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A VideoReview belongs to a Video.
     *
     * @return mixed
     */
    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Create a video review.
     *
     * @param $request
     * @param $user
     * @param $video
     * @return $this|Model
     * @throws UserAlreadyReviewedException
     * @internal param $bookId
     */
    public function createReview($request, $user, $video)
    {
        $review = $this->where('user_id', $user->id)->first();
        if ($review) {
            throw new UserAlreadyReviewedException;
        }

        $review = $this->create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'rating' => $request->rating,
            'comments' => $request->comments
        ]);

        event(new VideoRated($review));

        return $review;
    }

    /**
     * Update a video review.
     *
     * @param $request
     * @param $review
     * @return $this|Model
     */
    public function updateReview($request, $review)
    {
        $review->update($request->all());

        event(new VideoRated($review));

        return $review;
    }
}
