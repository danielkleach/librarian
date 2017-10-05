<?php

namespace App\Providers;

use App\Book;
use App\BookReview;
use App\DigitalBook;
use App\VideoReview;
use App\FavoriteBook;
use App\Policies\BookPolicy;
use App\Policies\BookReviewPolicy;
use App\Policies\VideoReviewPolicy;
use App\Policies\DigitalBookPolicy;
use App\Policies\FavoriteBookPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Book::class => BookPolicy::class,
        DigitalBook::class => DigitalBookPolicy::class,
        FavoriteBook::class => FavoriteBookPolicy::class,
        BookReview::class => BookReviewPolicy::class,
        VideoReview::class => VideoReviewPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
