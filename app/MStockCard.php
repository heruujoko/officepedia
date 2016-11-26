<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MWarehouse;
use App\MGoods;
use Auth;

class MStockCard extends Model
{
    protected $table = "mstockcard";

    public function gudang(){
        return MWarehouse::on(Auth::user()->db_name)->where('id',$this->mstockcardwhouse)->first();
    }

    public function goods(){
        return MGoods::on(Auth::user()->db_name)->where('mgoodscode',$this->mstockcardgoodsid)->first();
    }
}
