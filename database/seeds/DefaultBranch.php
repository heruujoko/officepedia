<?php

use Illuminate\Database\Seeder;
class DefaultBranch extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mbranch')->insert([
            'mbranchcode' => 'BRN000001',
            'mbranchname' => 'Cabang Utama',
            'address' => "",
            'phone' => "",
            'city' => "",
            'person_in_charge' => "",
            'information' => "",
            'void' => 0
        ]);
    }
}
