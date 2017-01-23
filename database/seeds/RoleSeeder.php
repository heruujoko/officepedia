<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\MUser;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'Administrator'
        ]);
    }
}
