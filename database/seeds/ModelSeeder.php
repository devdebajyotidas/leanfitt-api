<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        DB::table('report_categories')->insert([
            ['name'=>'Healthcare roadmap/gemba walk'],
            ['name'=>'Healthcare value strem map'],
            ['name'=>'Healthcare leadership'],
            ['name'=>'Healthcare standard work'],
            ['name'=>'Healthcare kaizen event'],
            ['name'=>'Healthcare quality tools'],
            ['name'=>'Healthcare 5s audit'],
            ['name'=>'Healthcare 6s audit'],
            ['name'=>'Healthcare A3 project report'],
            ['name'=>'Healthcare waste audit'],
            ['name'=>'Lean scatter plot'],
            ['name'=>'Lean run chart'],
            ['name'=>'Lean stakeholder analysis'],
            ['name'=>'Lean pareto chart'],
            ['name'=>'Lean histogram'],
            ['name'=>'Lean five whys analysis'],
            ['name'=>'Lean impact map'],
            ['name'=>'Lean brainstorming'],
            ['name'=>'Manufacturing 5s audit'],
            ['name'=>'Manufacturing 6s audit'],
            ['name'=>'Manufacturing waste audit'],
            ['name'=>'Manufacturing gemba walk'],
            ['name'=>'Manufacturing A3 project report'],
        ]);

        /*Some table needs manual inputs to maintain relational integrity*/
    }
}
