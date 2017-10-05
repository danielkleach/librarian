<?php

namespace Tests\Unit;

use App\User;
use App\Video;
use Tests\TestCase;
use App\VideoReview;
use App\Exceptions\UserAlreadyReviewedException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoReviewTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanOnlyLeaveASingleReviewForAVideo()
    {
        $user = factory(User::class)->create();

        $video = factory(Video::class)->create();

        factory(VideoReview::class)->create([
            'user_id' => $user->id,
            'video_id' => $video->id
        ]);

        $review = new VideoReview();

        $data = (object) [
            'rating' => 3,
            'comments' => 'This video is decent.'
        ];

        try {
            $review->createReview($data, $user, $video);
        } catch (UserAlreadyReviewedException $e) {
            $reviews = $video->reviews()->where('user_id', $user->id)->get();
            $this->assertEquals(1, $reviews->count());
            return;
        }

        $this->fail("Review was created even though user has already reviewed this video.");
    }
}
