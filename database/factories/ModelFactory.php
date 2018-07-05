<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
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
        'name'=>$faker->sentence,
        'description'=>$faker->text(50),
        'due_date'=>Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp()),
        'board_id'=>rand(1,9),
        'assignor_id'=>1,
        'itemable_type'=>'App\Models\Project',
        'itemable_id'=>$faker->randomDigit,
        'position'=>$faker->randomDigit,
        'created_by'=>$faker->randomDigit
    ];
});

$factory->define(App\Models\ActionItemAssignee::class, function (Faker $faker) {
    return [
        'use_id'=>$faker->randomDigit,
    ];
});

$factory->define(App\Models\Attachment::class, function (Faker $faker) {
    return [
        'attachable_type'=>'App\Models\ActionItem',
        'attachable_id'=>$faker->randomDigit,
        'url'=>$faker->imageUrl(640,480),
        'created_by'=>$faker->randomDigit,
    ];
});

$factory->define(App\Models\Award::class, function (Faker $faker){
    return [
        'employee_id'=>rand(1,10),
        'title' => 'Award for quiz',
        'type' => 'quiz',
        'description'=>$faker->sentence
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
        'action_item_id'=>rand(1,10),
    ];
});

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $id=$faker->randomDigit;
    return [
        'user_id'=>rand(1,10),
        'comment'=>$faker->text('100'),
        'commentable_type'=>'App\Models\ActionItem',
        'commentable_id'=>$id,
        'created_by'=>$faker->randomDigit,
    ];
});

$factory->define(App\Models\Department::class, function (Faker $faker) {
    return [
        'name'=>$faker->jobTitle,
        'created_by'=>$faker->randomDigit,
    ];
});

$factory->define(App\Models\Device::class, function (Faker $faker) {
    return [
        'uuid'=>$faker->uuid,
        'fcm_token'=>$faker->md5,
        'api_token'=>$faker->sha1,
    ];
});

$factory->define(App\Models\Employee::class, function (Faker $faker) {
    return [
        'designation'=>$faker->jobTitle,
        'user_id'=>rand(1,10)
    ];
});

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    return [];
});

$factory->define(App\Models\KpiChart::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence,
        'x_label'=>'Date',
        'y_label'=>'Money',
        'start_date'=>$startDate=Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp()),
        'end_date'=> Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addDays(30),
        'created_by'=>$faker->randomDigit,
    ];
});

$factory->define(App\Models\KpiDataPoint::class, function (Faker $faker) {
    return [
        'value'=>$faker->randomDigit,
        'target_date'=>Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp()),
        'created_by'=>$faker->randomDigit,
    ];
});

$factory->define(App\Models\Label::class, function (Faker $faker) {
    return [
        'label'=>$faker->word,
        'color'=>$faker->hexColor,
        'action_item_id'=>rand(1,10),
    ];
});

$factory->define(App\Models\LeanTool::class, function (Faker $faker) {
    $quiz=array();
    for ($i=0;$i<10;$i++){
        $question=$faker->paragraph;
        $answers=array();
        $answer_type_arr=['true','false','false','false'];
        for($j=0;$j<4;$j++){
            $answer=$faker->paragraph;
            $answer_type=$answer_type_arr[$j];
            $answers[]=['answer'=>$answer,'type'=>$answer_type];
        }
        $content=$answers;
        $quiz[]=['question'=>$question,'content'=>$content];
    }

    $assessment=array();
    for ($i=0;$i<10;$i++) {
        $as = $faker->paragraph;
        array_push($assessment,$as);
    }

    return [
        'name'=>$faker->word,
        'overview'=>$faker->text(),
        'case_studies'=>$faker->text(),
        'steps'=>$faker->text(),
        'quiz'=>json_encode($quiz),
        'assessment'=>json_encode($assessment),
        'created_by'=>$faker->randomDigit,
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

$factory->define(App\Models\OrganizationAdmin::class, function (Faker $faker) {
    return [
        'admin_id'=>rand(1,10)
    ];
});

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'organization_id'=>rand(1,10),
        'name'=>$faker->sentence,
        'goal'=>$faker->paragraph,
        'lean_sensie'=>rand(1,10),
        'leader'=>rand(1,10),
        'start_date'=>$startDate=Carbon::createFromTimeStamp($faker->dateTimeBetween('-30 days', '+30 days')->getTimestamp()),
        'end_date'=> Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addDays(30),
        'note'=>$faker->paragraph,
        'report_date'=>Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addDays(30),
        'created_by'=>$faker->randomDigit,
    ];
});

$factory->define(App\Models\QuizResult::class, function (Faker $faker) {
    $quiz=10;
    $correct=$quiz-rand(0,9);
    $incorrect=$quiz-$correct;
    $score=($correct/$quiz)*100;

    return [
        'lean_tool_id'=>rand(1,10),
        'employee_id'=>rand(1,10),
        'score'=>$score,
        'correct'=>$correct,
        'incorrect'=>$incorrect
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
        'verification_token'=>$faker->uuid,
    ];
});
