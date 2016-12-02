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
            $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$d->mstockcardtransno)->where('mdinvoicegoodsid',$d->mstockcardgoodsid)->first();
            $verbs = "";
            if($details->mdinvoiceunit3 != 0){
                $verbs .= $details->mdinvoiceunit3." ".$details->mdinvoiceunit3label;
            }
            if($details->mdinvoiceunit2 != 0){
                $verbs .= " ".$details->mdinvoiceunit2." ".$details->mdinvoiceunit2label;
            }
            if($details->mdinvoiceunit1 != 0){
                $verbs .= " ".$details->mdinvoiceunit1." ".$details->mdinvoiceunit1label;
            }
        } else {
            $details = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$d->mstockcardtransno)->where('mdpurchasegoodsid',$d->mstockcardgoodsid)->first();
            $verbs = "";
            if($details->mdpurchasegoodsunit3 != 0){
                $verbs .= $details->mdpurchasegoodsunit3." ".$details->mdpurchasegoodsunit3label;
            }
            if($details->mdpurchasegoodsunit2 != 0){
                $verbs .= " ".$details->mdpurchasegoodsunit2." ".$details->mdpurchasegoodsunit2label;
            }
            if($details->mdpurchasegoodsunit1 != 0){
                $verbs .= " ".$details->mdpurchasegoodsunit1." ".$details->mdpurchasegoodsunit1label;
            }
        }
        $d['verbs'] = $verbs;

    }

    return response()->json($data);
  }

}
