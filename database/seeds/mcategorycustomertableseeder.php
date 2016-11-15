<?php

use Illuminate\Database\Seeder;
use App\MCategorycustomer;
class mcategorycustomertableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mcategorycustomer')->insert([
            'category_name' => 'Umum',
            'information' => 'umum',
            'void' => 0

        ]);
    }
}
