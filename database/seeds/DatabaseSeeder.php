<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);

        $admin = factory(App\Models\User::class)->create();
        $admin->email = 'admin@example.com';
        $admin->save();
        if($admin){
            $admin->attachRole('admin');
        }
    }
}
