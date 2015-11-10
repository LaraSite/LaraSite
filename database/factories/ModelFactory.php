<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//$factory->define(App\User::class, function ($faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->email,
//        'password' => str_random(10),
//        'remember_token' => str_random(10),
//    ];
//});


$factory->define(Illuminate\Auth\GenericUser::class, function ($faker) {
    return [
        'id' => 'admin',
        'username' => 'admin',
        'password' => 'admin123',
    ];
});

$factory->define(App\Entities\Article::class, function ($faker) {
    /** @var Faker\Generator $faker */

    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'status' => 'Published',
        'published_at' => \Carbon\Carbon::today(),
    ];
});

$factory->define(App\Entities\Category::class, function ($faker) {
    /** @var Faker\Generator $faker */

    static $sequence = 0;
    $sequence++;

    return [
        'name' => "Category-{$sequence}",
    ];
});

$factory->define(App\Entities\Tag::class, function ($faker) {
    /** @var Faker\Generator $faker */

    static $sequence = 0;
    $sequence++;

    return [
        'name' => "Tag-{$sequence}",
    ];
});

$factory->define(App\Entities\UploadFile::class, function ($faker) {
    /** @var Faker\Generator $faker */

    return [
        'extension' => 'jpeg',
        'size' => 1024,
    ];
});
