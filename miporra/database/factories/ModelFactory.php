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

$factory->define(App\User::class, function (Faker\Generator $faker) 
{
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\Championship::class, function (Faker\Generator $faker) 
{
    return [
	'name' => $faker->name,
	'code' => $faker->unique,
	'start_date' => $faker->dateTimeBetween('+1 day', '+1 month'),
	'end_date' => $faker->dateTimeBetween('+1 month', '+2 month'),
	'created_at' => $faker->dateTime(),
	'updated_at' => $faker->dateTime()
    ];
});

$factory->defineAs(App\Models\Championship::class,'notStarted', function (Faker\Generator $faker) use ($factory)
{
	$championship = $factory->raw(App\Models\Championship::class);

    	return array_merge(
    		$championship, 
    		[
    			'start_date' => $faker->dateTimeBetween('+1 day', '+1 month'),
    			'end_date' => $faker->dateTimeBetween('+1 month', '+2 month')
    		]
    	);
});

$factory->defineAs(App\Models\Championship::class,'inProgress', function (Faker\Generator $faker) use ($factory) 
{
	$championship = $factory->raw(App\Models\Championship::class);

    	return array_merge(
    		$championship, 
    		[
    			'start_date' => $faker->dateTimeBetween('-1 month', '-1 day'),    	
    			'end_date' => $faker->dateTimeBetween('+1 month', '+2 month')
    		]
    	);
});

$factory->defineAs(App\Models\Championship::class,'ended', function (Faker\Generator $faker) use ($factory) 
{
	$championship = $factory->raw(App\Models\Championship::class);

    	return array_merge(
    		$championship, 
    		[
    			'start_date' => $faker->dateTimeBetween('-3 month', '-2 month'),
    			'end_date' => $faker->dateTimeBetween('-2 month', '-1 month')
    		]
    	);
});

