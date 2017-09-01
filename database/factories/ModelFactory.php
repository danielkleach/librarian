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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

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

$factory->define(App\Book::class, function (Faker $faker) {

    return [
        'title' => $faker->sentence,
        'description' => $faker->text(200),
        'isbn' => $faker->isbn10,
        'publication_year' => $faker->year,
        'location' => $faker->word,
        'status' => $faker->boolean(90)
            ? $faker->randomElement(['available', 'unavailable'])
            : $faker->randomElement(['lost', 'removed']),
    ];
});

$factory->state(App\Book::class, 'withCategory', function ($faker) {
    return [
        'category_id' => factory(Category::class)->lazy()
    ];
});

$factory->state(App\Book::class, 'withAuthor', function ($faker) {
    return [
        'author_id' => factory(Author::class)->lazy()
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

$factory->state(App\Book::class, 'withRandomAuthor', function ($faker) {
    return [
        'author_id' => Author::all()->random()->id
    ];
});

$factory->state(App\Book::class, 'withRandomUser', function ($faker) {
    return [
        'owner_id' => User::all()->random()->id
    ];
});

$factory->define(App\Tracker::class, function (Faker $faker) {

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

$factory->state(App\Tracker::class, 'withUser', function ($faker) {
    return [
        'user_id' => factory(User::class)->lazy()
    ];
});

$factory->state(App\Tracker::class, 'withBook', function ($faker) {
    return [
        'book_id' => factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->lazy()
    ];
});

$factory->state(App\Tracker::class, 'withRandomUser', function ($faker) {
    return [
        'user_id' => User::all()->random()->id
    ];
});

$factory->state(App\Tracker::class, 'withRandomBook', function ($faker) {
    return [
        'book_id' => Book::all()->random()->id
    ];
});

$factory->define(App\UserReview::class, function (Faker $faker) {

    return [
        'rating' => $faker->numberBetween(1, 5),
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
        'book_id' => factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->lazy()
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
