<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Faker\Provider\en_Us\Company as Company;
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
        'description'=>$faker->text(50),
        'due_date'=>$faker->date('Y-m-d','30'),
    ];
});

$factory->define(App\Models\Attachment::class, function (Faker $faker) {
    return [
        'url'=>$faker->imageUrl(640,480)
    ];
});

$factory->define(App\Models\Award::class, function (Faker $faker){
    return [
        'title' => $faker->sentence,
        'type' => 'quiz',
        'description'=>$faker->paragraph
    ];
});

$factory->define(App\Models\Board::class, function (Faker $faker) {
    return [
        'name'=>$faker->sentence,
    ];
});

$factory->define(App\Models\Checklist::class, function (Faker $faker) {
    return [
        'label'=>$faker->sentence,
        'is_checked'=>rand(0,1),
    ];
});

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'comment'=>$faker->text('100'),
    ];
});

$factory->define(App\Models\Department::class, function (Company $faker) {
    return [
         'name'=>$faker->jobTitle(),
    ];
});

$factory->define(App\Models\Device::class, function (Faker $faker) {
    return [
        'uuid'=>Uuid::uuid1()->toString(),
        'fcm_token'=>Uuid::uuid1()->toString(),
        'api_token'=>Uuid::uuid1()->toString(),
    ];
});

$factory->define(App\Models\Employee::class, function (Company $faker) {
    return [
         'designation'=>$faker->jobTitle(),
    ];
});

$factory->define(App\Models\KpiChart::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence,
        'x_label'=>'Date',
        'y_label'=>'Money',
        'start_date'=>$startDate=Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp()),
        'end_date'=> Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addDays(30)
    ];
});

$factory->define(App\Models\KpiDataPoint::class, function (Faker $faker) {
    return [
        'value'=>$faker->randomDigit,
        'target_date'=>Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp())
    ];
});

$factory->define(App\Models\Label::class, function (Faker $faker) {
    return [
        'label'=>$faker->word,
        'color'=>$faker->hexColor,
    ];
});

$factory->define(App\Models\LeanTool::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'overview'=>$faker->text(),
        'case_studies'=>$faker->text(),
        'quiz'=>null,
    ];
});

$factory->define(App\Models\Organization::class, function (Faker $faker) {
    return [
        'name'=>$faker->company,
        'email'=>$faker->companyEmail,
        'phone'=>$faker->phoneNumber,
        'contact_person'=>$faker->firstName.' '.$faker->lastName,
        'featured_image'=>$faker->imageUrl(480,480)
    ];
});

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'name'=>$faker->sentence,
        'goal'=>$faker->paragraph,
        'start_date'=>$startDate=Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp()),
        'end_date'=> Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addDays(30),
        'note'=>$faker->paragraph,
        'report_date'=>Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addDays(30),
    ];
});

$factory->define(App\Models\QuizResult::class, function (Faker $faker) {
    $quiz=10;
    $correct=$quiz-rand(0,9);
    $incorrect=$quiz-$correct;
    $score=($correct/$quiz)*100;

    return [
        'score'=>$score,
        'correct'=>$correct,
        'incorrenct'=>$incorrect
    ];
});

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'first_name'=>$faker->firstName,
        'last_name'=>$faker->lastName,
        'email'=>$faker->safeEmail,
        'phone'=>$faker->phoneNumber,
        'avatar'=>$faker->imageUrl(480,480),
        'password'=>'secret',
        'verification_token'=>Uuid::uuid1()->toString(),
    ];
});