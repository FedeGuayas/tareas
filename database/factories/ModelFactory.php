<?php

use App\User;
use App\Area;
use Illuminate\Support\Facades\DB;
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

$factory->define(Area::class, function (Generator $faker) {
    $array= [
        'area' => $faker->sentence($nbWords = 2, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 100)
    ];
    return $array;
});

$factory->define(User::class, function (Generator $faker) {
    $area_ids = DB::table('areas')->select('id')->get();
    $area_id = $faker->randomElement($area_ids)->id;
    $array= [
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => str_random(10),
        'name'=> $faker->userName,
        'first_name'=>$faker->firstName($gender = null|'male'|'female'),
        'last_name'=>$faker->lastName,
        'phone'=>$faker->phoneNumber,
        'activated'=>true,
        'area_id' => $area_id,
    ];
    return $array;
    
});
