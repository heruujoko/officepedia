<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MStockCard;
use App\MGoods;
use App\MWarehouse;
use App\MBRANCH;
use App\UserBranch;
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

    // branch filter
    $branch_ids = UserBranch::on(Auth::user()->db_name)->where('userid',Auth::user()->id)->get();
    $branches = collect();
    foreach($branch_ids as $br){
        $br = MBRANCH::on(Auth::user()->db_name)->where('id',$br->branchid)->first();
        $branches->push($br);
    }

    $warehouse_ids = [];
    foreach ($branches as $br) {
        $wh = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$br->mbranchcode)->get();
        foreach($wh as $w){
            array_push($warehouse_ids,$w->id);
        }
    }

    $data = $query->whereIn('mstockcardwhouse',$warehouse_ids)->groupBy('mstockcardgoodsid')->get();

    $headers = [];
    $stocks =[];

    foreach($data as $dt){
        array_push($headers,array('mstockcardgoodsid' => $dt->mstockcardgoodsid,'mstockcardgoodsname' => $dt->mstockcardgoodsname));
    }

    foreach ($headers as $dtl) {
        $grp_h = array(
            'blank' => false,
            'data' => false,
            'footer' => false,
            'mstockcardgoodsid' => $dtl['mstockcardgoodsid'],
            'mstockcardgoodsname' => $dtl['mstockcardgoodsname'],
        );
        array_push($stocks,$grp_h);
        $grp_query = MStockCard::on(Auth::user()->db_name)->where('mstockcardgoodsid',$dtl['mstockcardgoodsid']);

        if ($request->has('start')) {
             $grp_query->whereDate('mstockcarddate','>=',Carbon::parse($request->start));
        }
        if($request->has('end')){
                $grp_query->whereDate('mstockcarddate','<=',Carbon::parse($request->end));
        }
        if ($request->has('mstockcardwhouse')) {
            $grp_query->where('mstockcardwhouse',$request->mstockcardwhouse);
        }

        $grp = $grp_query->get();
        foreach ($grp as $g) {

            $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g->mstockcardgoodsid)->first();

            $g['data'] = true;
            $g['blank'] = false;
            $g['footer'] = false;
            if($g->mstockcardstockin != 0){
                $g['verbs'] = UnitHelper::label($mgoods,$g->mstockcardstockin);
            } else {
                $g['verbs'] = UnitHelper::label($mgoods,$g->mstockcardstockout);
            }

            $g['gudang'] = $g->gudang()->mwarehousename;
            $g['cabang'] = $g->gudang()->cabang()->mbranchname;
            $g['single'] = UnitHelper::singlelabel($mgoods,$g->mstockcardstocktotal);
            array_push($stocks,$g);
        }

        $last_stock = end($stocks);

        $blank = array(
            'blank' => true,
            'data' => false,
            'footer' => false
        );

        $footer = array(
            'data' => false,
            'blank' => false,
            'footer' => true,
            'mstockcardgoodsid' => $last_stock['mstockcardgoodsid'],
            'mstockcardgoodsname' => $last_stock->mstockcardgoodsname,
            'mstockcardstocktotal' => $last_stock->mstockcardstocktotal,
            'mstockcardstockin' => $last_stock->mstockcardstockin,
            'mstockcardstockout' => $last_stock->mstockcardstockout,
            'verbs' => UnitHelper::label($mgoods,$last_stock->mstockcardstocktotal),
            'mstockcarddate' => $last_stock->mstockcarddate,
            'mstockcardtranstype' => $last_stock->mstockcardtranstype,
            'mstockcardtransno' => $last_stock->mstockcardtransno,
            'gudang' => $last_stock['gudang'],
            'mstockcardremark' => $last_stock->mstockcardremark
        );

        $footer['footer'] = true;
        $footer['data'] = false;
        array_push($stocks,$footer);
        array_push($stocks,$blank);

    }

    // foreach($data as $d){
    //     $d['gudang'] = $d->gudang()->mwarehousename;
    //     $d['goodsqty'] = $d->goods()->mgoodsstock;
    //     // get multi unit verbs
    //     if($d['mstockcardtranstype'] == 'Penjualan'){
    //         $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
    //         $verbs = UnitHelper::label($mgoods,$d->mstockcardstockout);
    //     } else {
    //         $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
    //         $verbs = UnitHelper::label($mgoods,$d->mstockcardstockin);
    //     }
    //     $d['verbs'] = $verbs;
    //
    // }

    return response()->json($stocks);
  }

}
