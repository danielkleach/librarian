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

Route::middleware('auth:api')->group(function () {

    Route::prefix('users')->group(function () {

        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');

        Route::prefix('{userId}')->group(function () {

            Route::get('/', 'UserController@show');
            Route::patch('/', 'UserController@update');
            Route::delete('/', 'UserController@destroy');
        });
    });

    Route::prefix('categories')->group(function () {

        Route::get('/', 'CategoryController@index');
        Route::post('/', 'CategoryController@store');

        Route::prefix('{categoryId}')->group(function () {

            Route::get('/', 'CategoryController@show');
            Route::patch('/', 'CategoryController@update');
            Route::delete('/', 'CategoryController@destroy');
        });
    });

    Route::prefix('authors')->group(function () {

        Route::get('/', 'AuthorController@index');
        Route::post('/', 'AuthorController@store');

        Route::prefix('{authorId}')->group(function () {

            Route::get('/', 'AuthorController@show');
            Route::patch('/', 'AuthorController@update');
            Route::delete('/', 'AuthorController@destroy');
        });
    });

    Route::prefix('books')->group(function () {

        Route::get('/', 'BookController@index');
        Route::post('/', 'BookController@store');

        Route::post('/checkout', 'BookCheckoutController@store');
        Route::post('/checkin', 'BookCheckinController@store');

        Route::prefix('{bookId}')->group(function () {

            Route::get('/', 'BookController@show');
            Route::patch('/', 'BookController@update');
            Route::delete('/', 'BookController@destroy');

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