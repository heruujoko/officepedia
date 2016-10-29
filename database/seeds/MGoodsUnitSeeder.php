<?php

use Illuminate\Database\Seeder;
use App\MUnit;

class MGoodsUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MUnit::create([
          'mgoodsunitname' => 'Unit',
          'void' => 0
        ]);
        MUnit::create([
          'mgoodsunitname' => 'Lusin',
          'void' => 0
        ]);
        MUnit::create([
          'mgoodsunitname' => 'Karton',
          'void' => 0
        ]);
    }
}
