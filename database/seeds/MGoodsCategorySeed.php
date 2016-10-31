<?php

use Illuminate\Database\Seeder;
use App\MCategorygoods;

class MGoodsCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      MCategorygoods::create([
        'category_name' => 'Persediaan Barang',
        'void' => 0
      ]);
      MCategorygoods::create([
        'category_name' => 'Jasa',
        'void' => 0
      ]);
    }
}
