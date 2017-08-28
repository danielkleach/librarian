<?php

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
        'category_id' => factory(Category::class)->lazy(),
        'author_id' => factory(Author::class)->lazy(),
        'title' => $faker->sentence,
        'description' => $faker->text(200),
        'cover_image' => $faker->imageUrl(200, 200),
        'isbn' => $faker->isbn10,
        'publication_year' => $faker->year,
        'owner' => $faker->name
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
        'user_id' => factory(User::class)->lazy(),
        'book_id' => factory(Book::class)->lazy(),
        'checkout_date' => $checkoutDate,
        'due_date' => $dueDate,
        'return_date' => $returnDate
    ];
});

$factory->define(App\UserReview::class, function (Faker $faker) {

    return [
        'user_id' => factory(User::class)->lazy(),
        'book_id' => factory(Book::class)->lazy(),
        'rating' => $faker->numberBetween(1, 5),
        'comments' => $faker->text(200)
    ];
});
