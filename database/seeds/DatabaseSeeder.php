<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(MCOAFullSeeder::class);
        // $this->call(ConfigSeeder::class);
        $this->call(create_mtax_seeder::class);
    }
}
