<?php

namespace Tests\Unit;

use App\Book;
use App\User;
use App\UserReview;
use Tests\TestCase;
use App\Exceptions\UserAlreadyReviewedException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserReviewTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanOnlyLeaveASingleReviewForABook()
    {
        $user = factory(User::class)->create();

        $book = factory(Book::class)->create();

        factory(UserReview::class)->create([
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);

        $review = new UserReview();

        $data = (object) [
            'rating' => 3,
            'comments' => 'This book is decent.'
        ];

        try {
            $review->createReview($data, $user, $book);
        } catch (UserAlreadyReviewedException $e) {
            $reviews = $book->userReviews()->where('user_id', $user->id)->get();
            $this->assertEquals(1, $reviews->count());
            return;
        }

        $this->fail("Review was created even though user has already reviewed this book.");
    }
}
