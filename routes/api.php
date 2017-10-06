<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['respondWithJson']], function() {

    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/logout', 'Auth\LoginController@logout');

    Route::get('/featured/books', 'FeaturedBookController@index');
    Route::get('/popular/books', 'PopularBookController@index');
    Route::get('/new/books', 'NewBookController@index');
    Route::get('/recommended/books', 'RecommendedBookController@index');

    Route::prefix('actors')->group(function () {
        Route::get('/', 'ActorController@index');

        Route::prefix('{actorId}')->group(function () {
            Route::get('/', 'ActorController@show');
        });
    });

    Route::prefix('authors')->group(function () {
        Route::get('/', 'AuthorController@index');

        Route::prefix('{authorId}')->group(function () {
            Route::get('/', 'AuthorController@show');
        });
    });

    Route::prefix('books')->group(function () {
        Route::get('/', 'BookController@index');
        Route::post('/search', 'BookSearchController@index');

        Route::prefix('{bookId}')->group(function () {
            Route::get('/', 'BookController@show');
        });
    });

    Route::prefix('digital-books')->group(function () {
        Route::get('/', 'DigitalBookController@index');

        Route::prefix('{bookId}')->group(function () {
            Route::get('/', 'DigitalBookController@show');
        });
    });

    Route::prefix('videos')->group(function () {
        Route::get('/', 'VideoController@index');
        Route::post('/search', 'VideoSearchController@index');

        Route::prefix('{videoId}')->group(function () {
            Route::get('/', 'VideoController@show');
        });
    });

    Route::group(['middleware' => ['auth:api']], function() {

        Route::prefix('actors')->group(function () {
            Route::post('/', 'ActorController@store');

            Route::prefix('{actorId}')->group(function () {
                Route::patch('/', 'ActorController@update');
                Route::delete('/', 'ActorController@destroy');
            });
        });

        Route::prefix('authors')->group(function () {
            Route::post('/', 'AuthorController@store');

            Route::prefix('{authorId}')->group(function () {
                Route::patch('/', 'AuthorController@update');
                Route::delete('/', 'AuthorController@destroy');
            });
        });

        Route::prefix('books')->group(function () {
            Route::post('/', 'BookController@store');
            Route::post('/lookup', 'BookLookupController@store');

            Route::prefix('{bookId}')->group(function () {
                Route::patch('/', 'BookController@update');
                Route::delete('/', 'BookController@destroy');
                Route::post('/checkout', 'BookCheckoutController@store');
                Route::post('/checkin/{rentalId}', 'BookCheckinController@store');

                Route::prefix('authors')->group(function () {
                    Route::post('/', 'BookAuthorController@store');
                    Route::delete('/{authorId}', 'BookAuthorController@destroy');
                });

                Route::prefix('cover-image')->group(function () {
                    Route::post('/', 'CoverImageController@store');
                    Route::delete('/', 'CoverImageController@destroy');
                });

                Route::prefix('tags')->group(function () {
                    Route::post('/', 'BookTagController@store');
                    Route::delete('/{tag}', 'BookTagController@destroy');
                });

                Route::prefix('book-reviews')->group(function () {
                    Route::post('/', 'BookReviewController@store');
                });
            });
        });

        Route::prefix('book-reviews/{reviewId}')->group(function () {
            Route::get('/', 'BookReviewController@show');
            Route::patch('/', 'BookReviewController@update');
            Route::delete('/', 'BookReviewController@destroy');
        });

        Route::prefix('digital-books')->group(function () {
            Route::post('/', 'DigitalBookController@store');
            Route::post('/lookup', 'DigitalBookLookupController@store');

            Route::prefix('{bookId}')->group(function () {
                Route::patch('/', 'DigitalBookController@update');
                Route::delete('/', 'DigitalBookController@destroy');
                Route::post('/download', 'BookDownloadController@store');

                Route::prefix('authors')->group(function () {
                    Route::post('/', 'DigitalBookAuthorController@store');
                    Route::delete('/{authorId}', 'DigitalBookAuthorController@destroy');
                });

                Route::prefix('cover-image')->group(function () {
                    Route::post('/', 'CoverImageController@store');
                    Route::delete('/', 'CoverImageController@destroy');
                });

                Route::prefix('tags')->group(function () {
                    Route::post('/', 'DigitalBookTagController@store');
                    Route::delete('/{tag}', 'DigitalBookTagController@destroy');
                });

                Route::prefix('book-reviews')->group(function () {
                    Route::post('/', 'BookReviewController@store');
                });
            });
        });

        Route::prefix('rentals')->group(function () {
            Route::delete('{rentalId}', 'RentalController@destroy');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index');
            Route::post('/', 'UserController@store');

            Route::prefix('{userId}')->group(function () {
                Route::get('/', 'UserController@show');
                Route::patch('/', 'UserController@update');
            });
        });

        Route::prefix('favorites')->group(function () {
            Route::delete('/{favoriteId}', 'FavoriteController@destroy');
        });

        Route::prefix('videos')->group(function () {
            Route::post('/', 'VideoController@store');
            Route::post('/lookup/search', 'VideoLookupController@index');
            Route::post('/lookup/create', 'VideoLookupController@store');

            Route::prefix('{videoId}')->group(function () {
                Route::patch('/', 'VideoController@update');
                Route::delete('/', 'VideoController@destroy');
                Route::post('/checkout', 'VideoCheckoutController@store');
                Route::post('/checkin/{rentalId}', 'VideoCheckinController@store');

                Route::prefix('actors')->group(function () {
                    Route::post('/', 'VideoActorController@store');
                    Route::delete('/{actorId}', 'VideoActorController@destroy');
                });

                Route::prefix('video-reviews')->group(function () {
                    Route::post('/', 'VideoReviewController@store');
                });
            });
        });

        Route::prefix('video-reviews/{reviewId}')->group(function () {
            Route::get('/', 'VideoReviewController@show');
            Route::patch('/', 'VideoReviewController@update');
            Route::delete('/', 'VideoReviewController@destroy');
        });
    });
});
