<?php

use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*User -> Admin*/
        factory(\App\Models\User::class,10)->create()->each(function ($u) {
            $u->admin()->save(factory(\App\Models\Admin::class)->make());
        });

        /*Organization ->( Department -> Employee, OrganizationAdmin )*/
        factory(\App\Models\Organization::class,10)->create()->each(function ($u) {
            $dep=$u->departments()->save(factory(\App\Models\Department::class)->make());
            $dep->employees()->save(factory(\App\Models\Employee::class)->make());
            $u->organizationAdmin()->save(factory(\App\Models\OrganizationAdmin::class)->make());
        });

        /*LeanTool*/
        factory(\App\Models\LeanTool::class,10)->create();

        /*Board*/
        factory(\App\Models\Board::class,10)->create();

        /*Project -> (Kpi Chart -> Kpi Data Points, Action Items)*/
        factory(\App\Models\Project::class,10)->create()->each(function ($u) {
            $kpi=$u->kpi()->save(factory(\App\Models\KpiChart::class)->make());
            $kpi->kpiData()->save(factory(\App\Models\KpiDataPoint::class)->make());
            $u->Actionitem()->save(factory(\App\Models\ActionItem::class)->make());
        });

        /*Label*/
        factory(\App\Models\Label::class,10)->create();

        /*Comments*/
        factory(\App\Models\Comment::class,20)->create();

        /*Quiz Result*/
        factory(\App\Models\QuizResult::class,10)->create();

        /*Award*/
        factory(\App\Models\Award::class,10)->create();


        /*Some table needs manual inputs to maintain relational integrity*/
    }
}
