<?php

use Illuminate\Database\Seeder;
use App\MGoodstype;
use App\MGoodssubtype;

class MGoodsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $parent = MGoodstype::create([
        'mgoodstypename' => 'Umum',
        'void' => 0
      ]);

      MGoodssubtype::create([
        'mgoodssubtypeparent' => $parent->mgoodstypename,
        'mgoodssubtypename' => 'Umum',
        'void' => 0
      ]);
    }
}
