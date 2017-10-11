<?php

use App\User;
use App\Book;
use App\Video;
use App\Ebook;
use App\Author;
use App\Category;
use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Author::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Actor::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Book::class, function (Faker $faker) {

    return [
        'owner_id' => null,
        'title' => $faker->sentence,
        'description' => $faker->text(200),
        'isbn' => $faker->isbn10,
        'publication_year' => $faker->year,
        'location' => $faker->word,
        'cover_image_url' => $faker->imageUrl(),
        'featured' => $faker->boolean(10)
    ];
});

$factory->state(App\Book::class, 'withCategory', function ($faker) {
    return [
        'category_id' => factory(Category::class)->lazy()
    ];
});

$factory->state(App\Book::class, 'withUser', function ($faker) {
    return [
        'owner_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\Book::class, 'withRandomCategory', function ($faker) {
    return [
        'category_id' => Category::all()->random()->id
    ];
});

$factory->state(App\Book::class, 'withRandomUser', function ($faker) {
    return [
        'owner_id' => User::all()->random()->id
    ];
});

$factory->define(App\Ebook::class, function (Faker $faker) {

    return [
        'title' => $faker->sentence,
        'description' => $faker->text(200),
        'isbn' => $faker->isbn10,
        'publication_year' => $faker->year,
        'cover_image_url' => $faker->imageUrl(),
        'featured' => $faker->boolean(10)
    ];
});

$factory->state(App\Ebook::class, 'withCategory', function ($faker) {
    return [
        'category_id' => factory(Category::class)->lazy()
    ];
});

$factory->state(App\Ebook::class, 'withRandomCategory', function ($faker) {
    return [
        'category_id' => Category::all()->random()->id
    ];
});

$factory->define(App\Download::class, function (Faker $faker) {
    return [];
});

$factory->state(App\Download::class, 'withUser', function ($faker) {
    return [
        'user_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\Download::class, 'withBook', function ($faker) {
    return [
        'book_id' => factory(Ebook::class)->lazy()
    ];
});

$factory->state(App\Download::class, 'withRandomUser', function ($faker) {
    return [
        'user_id' => User::all()->random()->id
    ];
});

$factory->state(App\Download::class, 'withRandomBook', function ($faker) {
    return [
        'book_id' => Ebook::all()->random()->id
    ];
});

$factory->define(App\Favorite::class, function (Faker $faker) {
    $favoritableType = $faker->randomElement([
        Book::class,
        Ebook::class,
        Video::class
    ]);

    $categoricalTypes = [
        Book::class,
        Ebook::class,
    ];

    if (in_array($favoritableType, $categoricalTypes)) {
        $favoritableId = factory($favoritableType)->states('withCategory')->lazy();
    }

    return [
        'favoritable_id' => $favoritableId ?? factory($favoritableType)->lazy(),
        'favoritable_type' => $favoritableType,
    ];
});

$factory->state(App\Favorite::class, 'withUser', function ($faker) {
    return [
        'user_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\Favorite::class, 'withRandomUser', function ($faker) {
    return [
        'user_id' => User::all()->random()->id
    ];
});

$factory->define(App\File::class, function (Faker $faker) {
    $format = $faker->randomElement(['pdf', 'epub', 'mobi']);

    return [
        'format' => $format,
        'path' => $faker->url,
        'filename' => $faker->word . '.' . $format
    ];
});

$factory->state(App\File::class, 'withBook', function ($faker) {
    return [
        'book_id' => factory(Ebook::class)->states(['withCategory'])->lazy()
    ];
});

$factory->state(App\File::class, 'withRandomBook', function ($faker) {
    return [
        'book_id' => Ebook::all()->random()->id
    ];
});

$factory->define(App\Rental::class, function (Faker $faker) {
    $rentableType = $faker->randomElement([
        Book::class,
        Video::class
    ]);

    $categoricalTypes = [
        Book::class
    ];

    if (in_array($rentableType, $categoricalTypes)) {
        $rentableId = factory($rentableType)->states('withCategory')->lazy();
    }

    $checkoutDate = $faker->dateTimeBetween(
        $startDate = '-3 years',
        $endDate = 'now'
    )->format($format = 'Y-m-d H:i:s');

    $dueDate = Carbon::createFromFormat('Y-m-d H:i:s', $checkoutDate)
        ->addDays(15)->format($format = 'Y-m-d H:i:s');

    $checkedIn = $faker->boolean(70);

    $returnDate = $checkedIn
        ? $faker->dateTimeBetween(
            Carbon::createFromFormat('Y-m-d H:i:s', $checkoutDate)->addDay()->format($format = 'Y-m-d H:i:s'),
            Carbon::createFromFormat('Y-m-d H:i:s', $dueDate)->addDays(30)->format($format = 'Y-m-d H:i:s')
        )
        : null;

    return [
        'rentable_id' => $rentableId ?? factory($rentableType)->lazy(),
        'rentable_type' => $rentableType,
        'checkout_date' => $checkoutDate,
        'due_date' => $dueDate,
        'return_date' => $returnDate
    ];
});

$factory->state(App\Rental::class, 'withUser', function ($faker) {
    return [
        'user_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\Rental::class, 'withRandomUser', function ($faker) {
    return [
        'user_id' => User::all()->random()->id
    ];
});

$factory->define(App\Review::class, function (Faker $faker) {
    $reviewableType = $faker->randomElement([
        Book::class,
        Ebook::class,
        Video::class
    ]);

    $categoricalTypes = [
        Book::class,
        Ebook::class,
    ];

    if (in_array($reviewableType, $categoricalTypes)) {
        $reviewableId = factory($reviewableType)->states('withCategory')->lazy();
    }

    return [
        'reviewable_id' => $reviewableId ?? factory($reviewableType)->lazy(),
        'reviewable_type' => $reviewableType,
        'rating' => $faker->numberBetween(1, 4),
        'comments' => $faker->text(200)
    ];
});

$factory->state(App\Review::class, 'withUser', function ($faker) {
    return [
        'user_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\Review::class, 'withRandomUser', function ($faker) {
    return [
        'user_id' => User::all()->random()->id
    ];
});

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('Tester12'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'admin', function ($faker) {
    return [
        'is_admin' => true
    ];
});

$factory->define(App\Video::class, function (Faker $faker) {

    return [
        'owner_id' => null,
        'title' => $faker->sentence,
        'description' => $faker->text(200),
        'release_date' => $faker->dateTimeBetween(
            $startDate = '-20 years',
            $endDate = '-2 years'
        )->format($format = 'Y-m-d'),
        'location' => $faker->word,
        'thumbnail_path' => $faker->imageUrl(),
        'header_path' => $faker->imageUrl(),
        'runtime' => $faker->numberBetween(60, 250),
        'content_rating' => $faker->boolean(80)
            ? $faker->randomElement(['G', 'PG', 'PG-13', 'R'])
            : $faker->randomElement(['NC-17', 'Not Rated', 'Unrated']),
        'featured' => $faker->boolean(10)
    ];
});

$factory->state(App\Video::class, 'withUser', function ($faker) {
    return [
        'owner_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\Video::class, 'withRandomUser', function ($faker) {
    return [
        'owner_id' => User::all()->random()->id
    ];
});
