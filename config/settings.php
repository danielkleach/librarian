<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Rental Period
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of days that a rental is provided before
    | it is due back.
    |
    */

    'rental_period' => 14,
    'tmdb' => [
        'url' => 'https://api.themoviedb.org/3/search/movie',
        'api_key' => env('TMDB_API_KEY', null),
        'images' => [
            'base_url' => 'https://image.tmdb.org/t/p/w154'
        ]
    ],
];
