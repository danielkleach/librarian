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

    Route::prefix('digital-books')->group(function () {
        Route::get('/', 'DigitalBookController@index');

        Route::prefix('{bookId}')->group(function () {
            Route::get('/', 'DigitalBookController@show');
        });
    });

    Route::group(['middleware' => ['auth:api']], function() {

        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index');
            Route::post('/', 'UserController@store');

            Route::prefix('{userId}')->group(function () {
                Route::get('/', 'UserController@show');
                Route::patch('/', 'UserController@update');

                Route::prefix('favorites')->group(function () {
                    Route::get('/', 'FavoriteBookController@index');
                    Route::post('/', 'FavoriteBookController@store');

                    Route::prefix('{favoriteBookId}')->group(function () {
                        Route::delete('/', 'FavoriteBookController@destroy');
                    });
                });
            });
        });

        Route::prefix('categories')->group(function () {
            Route::post('/', 'CategoryController@store');

            Route::prefix('{categoryId}')->group(function () {
                Route::patch('/', 'CategoryController@update');
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
                Route::post('/checkin/{rentalId}', 'BookCheckinController@store');

                Route::prefix('authors')->group(function () {
                    Route::post('/', 'BookAuthorController@store');
                    Route::delete('/{authorId}', 'BookAuthorController@destroy');
                });

                Route::prefix('cover-image')->group(function () {
                    Route::post('/', 'CoverImageController@store');
                    Route::delete('/', 'CoverImageController@destroy');
                });

                Route::prefix('user-reviews')->group(function () {
                    Route::post('/', 'UserReviewController@store');
                });
            });
        });

        Route::prefix('digital-books')->group(function () {
            Route::post('/', 'DigitalBookController@store');

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

                Route::prefix('user-reviews')->group(function () {
                    Route::post('/', 'UserReviewController@store');
                });
            });
        });

        Route::prefix('rentals')->group(function () {
            Route::delete('{rentalId}', 'RentalController@destroy');
        });

        Route::prefix('user-reviews/{reviewId}')->group(function () {
            Route::get('/', 'UserReviewController@show');
            Route::patch('/', 'UserReviewController@update');
            Route::delete('/', 'UserReviewController@destroy');
        });
    });
});
