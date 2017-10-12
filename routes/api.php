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

    Route::get('/featured/{itemType}', 'FeaturedItemController@index');
    Route::get('/popular/{itemType}', 'PopularItemController@index');
    Route::get('/new/{itemType}', 'NewItemController@index');
    Route::get('/recommended/{itemType}', 'RecommendedItemController@index');

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

    Route::prefix('categories')->group(function () {
        Route::get('/', 'CategoryController@index');

        Route::prefix('{categoryId}')->group(function () {
            Route::get('/', 'CategoryController@show');
        });
    });

    Route::prefix('books')->group(function () {
        Route::get('/', 'Books\BookController@index');
        Route::post('/search', 'Books\BookSearchController@index');

        Route::prefix('{bookId}')->group(function () {
            Route::get('/', 'Books\BookController@show');
        });
    });

    Route::prefix('ebooks')->group(function () {
        Route::get('/', 'Ebooks\EbookController@index');

        Route::prefix('{bookId}')->group(function () {
            Route::get('/', 'Ebooks\EbookController@show');
        });
    });

    Route::prefix('genres')->group(function () {
        Route::get('/', 'GenreController@index');

        Route::prefix('{genreId}')->group(function () {
            Route::get('/', 'GenreController@show');
        });
    });

    Route::prefix('videos')->group(function () {
        Route::get('/', 'Videos\VideoController@index');
        Route::post('/search', 'Videos\VideoSearchController@index');

        Route::prefix('{videoId}')->group(function () {
            Route::get('/', 'Videos\VideoController@show');
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
            Route::post('/', 'Books\BookController@store');
            Route::post('/lookup', 'Books\BookLookupController@store');

            Route::prefix('{bookId}')->group(function () {
                Route::patch('/', 'Books\BookController@update');
                Route::delete('/', 'Books\BookController@destroy');
                Route::post('/checkout', 'Books\BookCheckoutController@store');
                Route::post('/checkin/{rentalId}', 'Books\BookCheckinController@store');

                Route::prefix('authors')->group(function () {
                    Route::post('/', 'Books\BookAuthorController@store');
                    Route::delete('/{authorId}', 'Books\BookAuthorController@destroy');
                });

                Route::prefix('tags')->group(function () {
                    Route::post('/', 'Books\BookTagController@store');
                    Route::delete('/{tag}', 'Books\BookTagController@destroy');
                });
            });
        });

        Route::prefix('categories')->group(function () {
            Route::post('/', 'CategoryController@store');

            Route::prefix('{categoryId}')->group(function () {
                Route::patch('/', 'CategoryController@update');
                Route::delete('/', 'CategoryController@destroy');
            });
        });

        Route::prefix('ebooks')->group(function () {
            Route::post('/', 'Ebooks\EbookController@store');
            Route::post('/lookup', 'Ebooks\EbookLookupController@store');

            Route::prefix('{bookId}')->group(function () {
                Route::patch('/', 'Ebooks\EbookController@update');
                Route::delete('/', 'Ebooks\EbookController@destroy');
                Route::post('/download', 'Ebooks\EbookDownloadController@store');

                Route::prefix('authors')->group(function () {
                    Route::post('/', 'Ebooks\EbookAuthorController@store');
                    Route::delete('/{authorId}', 'Ebooks\EbookAuthorController@destroy');
                });

                Route::prefix('tags')->group(function () {
                    Route::post('/', 'Ebooks\EbookTagController@store');
                    Route::delete('/{tag}', 'Ebooks\EbookTagController@destroy');
                });
            });
        });

        Route::prefix('cover-image')->group(function () {

            Route::prefix('/{itemType}/{itemId}')->group(function () {
                Route::post('/', 'CoverImageController@store');
                Route::delete('/', 'CoverImageController@destroy');
            });
        });

        Route::prefix('favorites')->group(function () {
            Route::delete('/{favoriteId}', 'FavoriteController@destroy');
        });

        Route::prefix('genres')->group(function () {
            Route::post('/', 'GenreController@store');

            Route::prefix('{genreId}')->group(function () {
                Route::patch('/', 'GenreController@update');
                Route::delete('/', 'GenreController@destroy');
            });
        });

        Route::prefix('rentals')->group(function () {
            Route::delete('{rentalId}', 'RentalController@destroy');
        });

        Route::prefix('reviews')->group(function () {
            Route::post('/{itemType}/{itemId}', 'ReviewController@store');

            Route::prefix('{reviewId}')->group(function () {
                Route::patch('/', 'ReviewController@update');
                Route::delete('/', 'ReviewController@destroy');
            });
        });

        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index');
            Route::post('/', 'UserController@store');

            Route::prefix('{userId}')->group(function () {
                Route::get('/', 'UserController@show');
                Route::patch('/', 'UserController@update');
            });
        });

        Route::prefix('videos')->group(function () {
            Route::post('/', 'Videos\VideoController@store');
            Route::post('/lookup/search', 'Videos\VideoLookupController@index');
            Route::post('/lookup/create', 'Videos\VideoLookupController@store');

            Route::prefix('{videoId}')->group(function () {
                Route::patch('/', 'Videos\VideoController@update');
                Route::delete('/', 'Videos\VideoController@destroy');
                Route::post('/checkout', 'Videos\VideoCheckoutController@store');
                Route::post('/checkin/{rentalId}', 'Videos\VideoCheckinController@store');

                Route::prefix('actors')->group(function () {
                    Route::post('/', 'Videos\VideoActorController@store');
                    Route::delete('/{actorId}', 'Videos\VideoActorController@destroy');
                });

                Route::prefix('tags')->group(function () {
                    Route::post('/', 'Videos\VideoTagController@store');
                    Route::delete('/{tag}', 'Videos\VideoTagController@destroy');
                });
            });
        });
    });
});
