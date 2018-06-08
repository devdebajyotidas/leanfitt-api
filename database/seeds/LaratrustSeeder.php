<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $role = new \App\Models\Role();
        $role->name = "admin";
        $role->display_name = "Super Admin";
        $role->description  = 'User is the Super Admin with global access';
        $role->save();

        $role = new \App\Models\Role();
        $role->name = "organization";
        $role->display_name = "Organization";
        $role->description  = 'User is an Admin with limited permissions';
        $role->save();

        $role = new \App\Models\Role();
        $role->name = "learner";
        $role->display_name = "Learner";
        $role->description  = 'User is a learner';
        $role->save();
    }
}
