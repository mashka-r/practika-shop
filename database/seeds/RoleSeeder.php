<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name = 'Admin';
        $admin->save();

        $manager = new Role();
        $manager->name = 'Manager';
        $manager->save();

        $registered = new Role();
        $registered->name = 'Registered';
        $registered->save();
        
    }
}
