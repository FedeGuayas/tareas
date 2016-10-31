<?php

use App\User;
use App\Area;
use App\Person;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;


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

//$factory->define(App\User::class, function (Faker\Generator $faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->safeEmail,
//        'password' => bcrypt(str_random(10)),
//        'remember_token' => str_random(10),
//    ];
//});

$factory->define(User::class, function (Generator $faker) {
    $array= [
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
    return $array;
});

$factory->define(Area::class, function (Generator $faker) {
    $array= [
        'area' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 100)
    ];
    return $array;
});

$factory->define(Person::class, function (Generator $faker) {
    $array= [
        'email' => $faker->email ,
        'phone' => $faker->phoneNumber,
        'first_name'=>$faker->firstName($gender = null|'male'|'female'),
        'last_name' => $faker->lastName,
        'area_id' => Area::all()->random()->id,
        'user_id' => User::all()->random()->id,
         
];
     return $array;
});


