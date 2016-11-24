<?php

use Illuminate\Database\Seeder;
use App\MStockCard;

class MStockcardreport extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MStockCard::create([
          'mgoodsunitname' => 'mstockcardgoodsid'
        ]);
        MStockCard::create([
          'mstockcardgoodsname' => 'Lusin'
        ]);
        MStockCard::create([
          'mstockcardtranstype' => 'Karton'
        ]);
    }
}
