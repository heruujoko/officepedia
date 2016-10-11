<?php

use Illuminate\Database\Seeder;
use App\MConfig;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MConfig::create([
          'msyscompname' => 'Sample Company'
        ]);
    }
}
