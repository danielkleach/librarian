<?php

namespace Tests\Unit;

use App\User;
use App\Book;
use App\Review;
use Tests\TestCase;
use App\Exceptions\UserAlreadyReviewedException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReviewTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanOnlyLeaveASingleReview()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->states(['withCategory'])->create();

        factory(Review::class)->create([
            'user_id' => $user->id,
            'reviewable_id' => $book->id,
            'reviewable_type' => get_class($book)
        ]);

        $review = new Review();

        $data = [
            'rating' => 3,
            'comments' => 'This book is decent.'
        ];

        try {
            $review->createReview($data, $user->id, $book);
        } catch (UserAlreadyReviewedException $e) {
            $reviews = $book->reviews()->where('user_id', $user->id)->get();
            $this->assertEquals(1, $reviews->count());
            return;
        }

        $this->fail("Review was created even though user has already reviewed this book.");
    }
}
