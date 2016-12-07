<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MStockCard;
use App\MGoods;
use App\MWarehouse;
use App\MDInvoice;
use App\MDPurchase;
use Datatables;
use DB;
use Auth;
use Carbon\Carbon;
use App\Helper\DBHelper;
use App\Helper\UnitHelper;

class MStockcardreportController extends Controller
{


  public function index(){
    $this->iteration = 0;
        $mbrand = MStockCard::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return response()->json($mbrand);
  }

  public function filter(Request $request){
    $query = MStockCard::on(Auth::user()->db_name);
    if ($request->has('start')) {
         $query->whereDate('mstockcarddate','>=',Carbon::parse($request->start));
    }
    if($request->has('end')){
            $query->whereDate('mstockcarddate','<=',Carbon::parse($request->end));
        }
    if($request->has('mstockcardgoodsid')){
            $query->where('mstockcardgoodsid',$request->mstockcardgoodsid);
    }
    if ($request->has('mstockcardwhouse')) {
        $query->where('mstockcardwhouse',$request->mstockcardwhouse);
    }
    // http://stackoverflow.com/questions/20731606/laravel-eloquent-inner-join-with-multiple-conditions
    // $query->join('mdinvoice',function($join){
    //     $join->on('mdinvoice.mhinvoiceno','=','mstockcard.mstockcardtransno');
    //     $join->on('mdinvoice.mdinvoicegoodsid','=','mstockcard.mstockcardgoodsid');
    // });
    $data = $query->get();

    foreach($data as $d){
        $d['gudang'] = $d->gudang()->mwarehousename;
        $d['goodsqty'] = $d->goods()->mgoodsstock;
        // get multi unit verbs
        if($d['mstockcardtranstype'] == 'Penjualan'){
            $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
            $verbs = UnitHelper::label($mgoods,$d->mstockcardstockout);
        } else {
            $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
            $verbs = UnitHelper::label($mgoods,$d->mstockcardstockin);
        }
        $d['verbs'] = $verbs;

    }

    return response()->json($data);
  }

}
