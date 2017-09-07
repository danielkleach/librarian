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

    Route::get('/featured/books', 'FeaturedBooksController@index');
    Route::get('/popular/books', 'PopularBooksController@index');
    Route::get('/new/books', 'NewBooksController@index');
    Route::get('/recommended/books', 'RecommendedBooksController@index');

    Route::prefix('categories')->group(function () {
        Route::get('/', 'CategoryController@index');

        Route::prefix('{categoryId}')->group(function () {
            Route::get('/', 'CategoryController@show');
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

        Route::prefix('{bookId}')->group(function () {
            Route::get('/', 'BookController@show');
        });
    });

    Route::group(['middleware' => ['auth:api']], function() {

        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index');
            Route::post('/', 'UserController@store');

            Route::prefix('{userId}')->group(function () {
                Route::get('/', 'UserController@show');
                Route::patch('/', 'UserController@update');
                Route::delete('/', 'UserController@destroy');

                Route::get('/trackers', 'UserTrackerController@index');
            });
        });

        Route::prefix('categories')->group(function () {
            Route::post('/', 'CategoryController@store');

            Route::prefix('{categoryId}')->group(function () {
                Route::patch('/', 'CategoryController@update');
                Route::delete('/', 'CategoryController@destroy');
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

            Route::prefix('{bookId}')->group(function () {
                Route::patch('/', 'BookController@update');
                Route::delete('/', 'BookController@destroy');
                Route::post('/checkout', 'BookCheckoutController@store');
                Route::post('/checkin', 'BookCheckinController@store');

                Route::prefix('cover-image')->group(function () {
                    Route::post('/', 'CoverImageController@store');
                    Route::delete('/', 'CoverImageController@destroy');
                });

                Route::prefix('user-reviews')->group(function () {
                    Route::post('/', 'UserReviewController@store');
                });
            });
        });

        Route::prefix('trackers')->group(function () {
            Route::delete('{trackerId}', 'TrackerController@destroy');
        });

        Route::prefix('user-reviews')->group(function () {
            Route::patch('{reviewId}', 'UserReviewController@update');
            Route::delete('{reviewId}', 'UserReviewController@destroy');
        });
    });
});
