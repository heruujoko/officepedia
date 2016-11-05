<?php

use Illuminate\Database\Seeder;
use App\MCategorysupplier;
use DB;

class DefaultSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_umum = MCategorysupplier::create([
          'category_name' => 'Umum',
          'void' => 0
        ]);

        DB::table('msupplier')->insert([
          'msupplierid' => 'SPL000001',
          'msuppliername' => 'Umum',
          'msuppliercoa' => 8,
          'msuppliercategory' => 1,
          'void' => 0
        ]);
    }
}
