<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\MWarehouse;

class MGoodsWarehouse extends Model
{
    protected $table = 'mgoodswarehouse';

    public static function createWarehouseStock($mgoodscode,$mwarehouseid){

      $wh = MWarehouse::on(Auth::user()->db_name)->where('id',$mwarehouseid)->first();

      $stock = new MGoodsWarehouse;
      $stock->setConnection(Auth::user()->db_name);
      $stock->mgoodscode = $mgoodscode;
      $stock->mwarehouseid = $mwarehouseid;
      $stock->mbranchid = $wh->mwarehousebranchid;
      $stock->stock = 0;
      $stock->save();

      return $stock;
    }
}
