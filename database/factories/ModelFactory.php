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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt("12345"),
        'db_alias' => 'mysql',
        'db_name' => 'mysql',
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\MGoods::class, function (Faker\Generator $faker) {
    return [
        'void' => 0,
        'mgoodsactive' => 1,
        'mgoodscategory' => 1,
        'mgoodstype' => 1,
        'mgoodstaxppn' => 1,
        'mgoodstaxppnbm' => 1,
        'mgoodssubtype' => 1,
        'mgoodsbranches' => 1,
        'mgoodsuniquetransaction' => 1,
        'mgoodsmultiunit' => 0,
        'mgoodssetmaxdisc' => 0,
        'mgoodstaxable' => 0,
        'mgoodssuppliercode' => 0,
        'mgoodscode' => "BRG000001010",
        'mgoodsbarcode' => str_random(10),
        'mgoodsname' => "Biji Kopi Aceh Gayo",
        'mgoodspriceout' => 10000,
        'mgoodssuppliercode' => "SPL000001",
        'mgoodssuppliername' => "Umum",
        'mgoodsunit' => "Unit",
    ];
});

$factory->define(App\MSupplier::class, function (Faker\Generator $faker) {
    return [
        'msupplierid' => 'SPL000001',
        'msuppliername' => 'Umum',
        'msuppliercoa' => 8,
        'msuppliercategory' => 1,
        'void' => 0
    ];
});
