<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MWarehouse;
use App\MGoods;
use Auth;

class MStockCard extends Model
{
    protected $table = "mstockcard";

    protected static function boot(){

        parent::boot();

        static::addGlobalScope('newest', function(Builder $builder) {
  		        $builder->orderBy('mstockcarddate','desc');
  	    });

    }

    public function gudang(){
        return MWarehouse::on(Auth::user()->db_name)->where('id',$this->mstockcardwhouse)->first();
    }

    public function goods(){
        return MGoods::on(Auth::user()->db_name)->where('mgoodscode',$this->mstockcardgoodsid)->first();
    }
}
