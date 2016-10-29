<?php

use Illuminate\Database\Seeder;
use App\MGoodsMark;

class MGoodsMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      MGoodsMark::create([
        'category_name' => 'Umum',
        'void' => 0
      ]);
    }
}
