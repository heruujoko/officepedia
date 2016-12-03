<?php

use Illuminate\Database\Seeder;
use App\MWarehouse;
class MWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
      MWarehouse::create([
         'mwarehousename' => 'Gudang Utama',
         'mwarehouseremark' => '',
         'void' => 0
      ]);

    }
}
