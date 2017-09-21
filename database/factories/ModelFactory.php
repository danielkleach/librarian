<?php

use App\Type;
use App\User;
use App\Book;
use App\Author;
use App\Tracker;
use App\Category;
use Carbon\Carbon;
use App\UserReview;
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

$factory->define(App\Category::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Author::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Role::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'slug' => $faker->name
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

$factory->define(App\Book::class, function (Faker $faker) {

    return [
        'owner_id' => null,
        'title' => $faker->sentence,
        'description' => $faker->text(200),
        'isbn' => $faker->isbn10,
        'publication_year' => $faker->year,
        'location' => $faker->word,
        'cover_image_url' => $faker->imageUrl(),
        'status' => $faker->boolean(90)
            ? $faker->randomElement(['available', 'unavailable'])
            : $faker->randomElement(['lost', 'removed']),
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

$factory->define(App\Rental::class, function (Faker $faker) {

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

$factory->state(App\Rental::class, 'withBook', function ($faker) {
    return [
        'book_id' => factory(Book::class)->states(['withCategory'])->lazy()
    ];
});

$factory->state(App\Rental::class, 'withRandomUser', function ($faker) {
    return [
        'user_id' => User::all()->random()->id
    ];
});

$factory->state(App\Rental::class, 'withRandomBook', function ($faker) {
    return [
        'book_id' => Book::all()->random()->id
    ];
});

$factory->define(App\UserReview::class, function (Faker $faker) {

    return [
        'rating' => $faker->numberBetween(1, 4),
        'comments' => $faker->text(200)
    ];
});

$factory->state(App\UserReview::class, 'withUser', function ($faker) {
    return [
        'user_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\UserReview::class, 'withBook', function ($faker) {
    return [
        'book_id' => factory(Book::class)->states(['withCategory'])->lazy()
    ];
});

$factory->state(App\UserReview::class, 'withRandomUser', function ($faker) {
    return [
        'user_id' => User::all()->random()->id
    ];
});

$factory->state(App\UserReview::class, 'withRandomBook', function ($faker) {
    return [
        'book_id' => Book::all()->random()->id
    ];
});

$factory->define(App\FavoriteBook::class, function (Faker $faker) {
    return [];
});

$factory->state(App\FavoriteBook::class, 'withUser', function ($faker) {
    return [
        'user_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\FavoriteBook::class, 'withBook', function ($faker) {
    return [
        'book_id' => factory(Book::class)->states(['withCategory'])->lazy()
    ];
});

$factory->state(App\FavoriteBook::class, 'withRandomUser', function ($faker) {
    return [
        'user_id' => User::all()->random()->id
    ];
});

$factory->state(App\FavoriteBook::class, 'withRandomBook', function ($faker) {
    return [
        'book_id' => Book::all()->random()->id
    ];
});
