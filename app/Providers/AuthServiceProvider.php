<?php

namespace App\Providers;

use App\UserReview;
use App\FavoriteBook;
use App\Policies\UserReviewPolicy;
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
