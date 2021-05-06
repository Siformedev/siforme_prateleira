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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password; 

    return [
        'name' => 'Administrador',
        'email' => 'tecnologia@agenciapni.com.br',
        'password' => bcrypt('leo228073'),
        'remember_token' => str_random(10),
        'userable_id' => 1,
        'userable_type' => 'App\\Forming',
    ];
});

$factory->define(App\Contract::class, function (Faker\Generator $faker) {

    return [
        'name' => 'FMU Turma 2019.2',
        'institution' => 'Centro Universitário das Faculdades Metropolitanas Unidas',
        'conclusion_year' => '2026',
        'conclusion_month' => '12',
        'email' => 'tecnologia@agenciapni.com.br',
        'signature_date' => '2022-02-20',
        'birthday_date' => '2022-03-01',
        'code' => 'direitofmu2019.2',
        'periodos' => '1',
        'valid' => 'Q2VudHJvIFVuaXZlcnNpdMOhcmlvIGRhcyBGYWN1bGRhZGVzIE1ldHJvcG9saXRhbmFzIFVuaWRhczox',
        'pseg_acc' => '2'
    ];
    /*
    return [
        'name' => 'Turma XPTO',
        'institution' => 'Instituição XPTO',
        'conclusion_year' => '2018',
        'conclusion_month' => '12',
        'email' => 'turmaxpto@agenciapni.com.br',
        'signature_date' => '2017-04-01',
        'birthday_date' => '2018-05-01',
        'code' => 'turmaxpto16',
        'valid' => '5G5JD89GDSUIF'
    ];
    */
});

/*
$factory->define(App\ProductAndServiceValues::class, function (Faker\Generator $faker) {

    return [
        'products_and_services_id' => '1',
        'maximum_parcels' => '18',
        'value' => '3200',
        'date_start' => '2017-01-01',
        'date_end' => '2017-12-01',
    ];
});
*/