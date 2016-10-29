<?php

use Illuminate\Database\Seeder;
use App\MTax;

class create_mtax_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MTax::create([
          'mtaxtype' => 'Pajak Pertambahan Nilai',
          'mtaxtdesc' => 'PPN 10%',
          'mtaxtpercentage' => 10
        ]);

        MTax::create([
          'mtaxtype' => 'Kosong',
          'mtaxtdesc' => 'Kosong',
          'mtaxtpercentage' => 0
        ]);
    }
}
