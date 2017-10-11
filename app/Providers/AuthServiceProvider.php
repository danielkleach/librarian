<?php

namespace App\Providers;

use App\Book;
use App\Ebook;
use App\Video;
use App\Review;
use App\Favorite;
use App\Policies\BookPolicy;
use App\Policies\EbookPolicy;
use App\Policies\VideoPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\FavoritePolicy;
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
        Review::class => ReviewPolicy::class,
        Ebook::class => EbookPolicy::class,
        Favorite::class => FavoritePolicy::class,
        Video::class => VideoPolicy::class,
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
