<?php

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


$factory->define(App\Models\ActionItem::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\ActionItemAssignee::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Attachment::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Award::class, function (Faker $faker){
    return [
        'title' => $faker->text(30),
        'type' => 'quiz',
        'description'=>$faker->text(100)
    ];
});

$factory->define(App\Models\Board::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Checklist::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Department::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Device::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Employee::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\KpiChart::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\KpiDataPoint::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Label::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\LeanTool::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Organization::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\OrganizationAdmin::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\QuizResult::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\Subscription::class, function (Faker $faker) {
    return [

    ];
});

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [

    ];
});