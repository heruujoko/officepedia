<?php

use Illuminate\Database\Seeder;

class MWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('mwarehouse')->insert([
          'mwarehousename' => 'Umum',
          'mwarehouseremark' => '',
          'void' => 0
      ]);
    }
}
