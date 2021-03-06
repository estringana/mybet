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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) 
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
            'code' => uniqid(),
	'start_date' => $faker->dateTimeBetween('+10 day', '+1 month'),
            'end_date' => $faker->dateTimeBetween('+1 month', '+2 month'),
	'end_inscription' => $faker->dateTimeBetween('+1 day', '+9 days'),
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

$factory->define(App\Models\Team::class, function (Faker\Generator $faker) 
{
    return [
        'name' => $faker->name,
        'code' => uniqid(),
        'short_code' => uniqid()
    ];
});

$factory->define(App\Models\Round::class, function (Faker\Generator $faker) 
{
    return [
        'name' => $faker->name,
        'identifier' => str_random(10),
        'order' => rand(0,1000),
        'points' => rand(1,5)
    ];
});


$factory->define(App\Models\Match::class, function (Faker\Generator $faker) 
{
    return [
            'date' => $faker->dateTimeBetween('1 month', '3 month'),
            'local_score' => null,
            'away_score' => null,
            'local_team_id' => null,
            'away_team_id' => null,
            'round_id' => null,
    ];
});

$factory->define(App\Models\Player::class, function (Faker\Generator $faker) 
{
    return [
            'name' => $faker->name
    ];
});

$factory->define(App\Models\Bet::class, function (Faker\Generator $faker) 
{
    return [
        'bettype_id' => 0,
        'bettype_type' => '',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});


$factory->define(App\Models\BetConfiguration::class, function (Faker\Generator $faker) 
{
    return [
                'bet_mapping_class' => uniqid(), 
                'order' => rand(1,100), 
                'number_of_bets' => rand(1,100),
                'points_per_guess' => rand(1,20)
    ];
});