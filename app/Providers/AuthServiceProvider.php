<?php

namespace App\Providers;

use App\Book;
use App\UserReview;
use App\DigitalBook;
use App\FavoriteBook;
use App\Policies\BookPolicy;
use App\Policies\UserReviewPolicy;
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
        UserReview::class => UserReviewPolicy::class,
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
