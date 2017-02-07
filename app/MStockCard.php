<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MWarehouse;
use App\MGoods;
use Auth;
use App\WarehouseStock;

class MStockCard extends Model
{
    protected $table = "mstockcard";

    protected static function boot(){

        parent::boot();

        static::addGlobalScope('newest', function(Builder $builder) {
  		        $builder->orderBy('mstockcarddate','desc');
  	    });

        static::created(function($stockcard){
          $relation = WarehouseStock::on(Auth::user()->db_name)->where('mgoodscode',$stockcard->mstockcardgoodsid)->where('mwarehouseid',$stockcard->mstockcardwhouse)->first();

          if($relation != null){
            $relation->stock += $stockcard->mstockcardstockin;
            $relation->stock -= $stockcard->mstockcardstockout;
            $relation->save();
          } else {
            $new_relation = new WarehouseStock;
            $new_relation->setConnection(Auth::user()->db_name);
            $new_relation->mgoodscode = $stockcard->mstockcardgoodsid;
            $new_relation->mwarehouseid = $stockcard->mstockcardwhouse;
            $new_relation->stock = $stockcard->mstockcardstockin;
            $new_relation->stock -= $stockcard->mstockcardstockout;
            $new_relation->save();
          }
        });

    }

    public function gudang(){
        return MWarehouse::on(Auth::user()->db_name)->where('id',$this->mstockcardwhouse)->first();
    }

    public function goods(){
        return MGoods::on(Auth::user()->db_name)->where('mgoodscode',$this->mstockcardgoodsid)->first();
    }
}
