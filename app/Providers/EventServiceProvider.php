<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\BookRented' => [
            'App\Listeners\IncrementTotalRentals',
            'App\Listeners\CheckoutBook',
        ],
        'App\Events\BookReturned' => [
            'App\Listeners\CheckinBook',
        ],
        'App\Events\BookRated' => [
            'App\Listeners\RecalculateBookRating',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
