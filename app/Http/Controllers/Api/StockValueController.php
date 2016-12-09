<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MGoods;
use DB;
use Auth;
use App\Helper\UnitHelper;
use Carbon\Carbon;
use App\MStockCard;
use App\MHPurchase;
use App\MCOGS;

class StockValueController extends Controller
{
    public function index(Request $request){
        // $query = DB::connection(Auth::user()->db_name)->table('mgoods')
        // ->join('mcogs','mgoods.mgoodscode','=','mcogs.mcogsgoodscode');
        //
        // if($request->has('spl')){
        //     $query->where('mgoodssuppliercode',$request->spl);
        // }
        //
        // if($request->has('goods')){
        //     $query->where('mgoodscode',$request->goods);
        // }
        //
        // $stockvalues = $query->orderBy('mgoodscode','asc')->get();
        // foreach($stockvalues as $st){
        //
        //     if($request->has('end')){
        //         $perdate_laststock = MStockCard::on(Auth::user()->db_name)->where('mstockcardgoodsid',$st->mgoodscode)->whereDate('mstockcarddate','<=',Carbon::parse($request->end))->orderBy('updated_at','desc')->first();
        //         if($perdate_laststock->mstockcardtranstype == 'Pembelian'){
        //             $st->stock = $perdate_laststock->mstockcardstocktotal + $perdate_laststock->mstockcardstockin;
        //         } else {
        //             $st->stock = $perdate_laststock->mstockcardstocktotal + $perdate_laststock->mstockcardstockout;
        //         }
        //         $st->verbs = UnitHelper::label($st,$st->stock);
        //     } else {
        //         $st->verbs = UnitHelper::label($st,$st->mgoodsstock);
        //     }
        //
        //
        // }
        $filter_invoices = [];

        if($request->has('spl')){
            $ivs = MHPurchase::on(Auth::user()->db_name)->where('mhpurchasesupplierid',$request->spl)->get();
            foreach($ivs as $iv){
                array_push($filter_invoices,$iv->mhpurchaseno);
            }
        }

        $stocks_query = MStockCard::on(Auth::user()->db_name);

        if($request->has('spl')){
            $stocks_query->whereIn('mstockcardtransno',$filter_invoices);
        }

        if($request->has('goods')){
            $stocks_query->where('mstockcardgoodsid',$request->goods);
        }

        if($request->has('end')){
            $stocks_query->whereDate('mstockcarddate','<=',Carbon::parse($request->end));
        }

        $stocks_group_goods = $stocks_query->groupBy('mstockcardgoodsid')->get();
        $goods_group = [];
        foreach ($stocks_group_goods as $st) {
            array_push($goods_group,$st->mstockcardgoodsid);
        }

        $stocks = [];
        foreach($goods_group as $grp){
            $stck_q = MStockCard::on(Auth::user()->db_name)->where('mstockcardgoodsid',$grp);

            if($request->has('end')){
                $stocks_query->whereDate('mstockcarddate','<=',$request->end);
            }

            if($request->has('goods')){
                $stocks_query->where('mstockcardgoodsid',$request->goods);
            }

            $stck = $stck_q->orderBy('created_at','desc')->first();

            if($stck->mstockcardtranstype == 'Pembelian'){
                $stck['stock'] = $stck->mstockcardstockin + $stck->mstockcardstocktotal;
            } else {
                $stck['stock'] = $stck->mstockcardstockout + $stck->mstockcardstocktotal;
            }
            $good = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$stck->mstockcardgoodsid)->first();
            $stck['verbs'] = UnitHelper::label($good,$stck['stock']);
            $stck['cogs'] = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$stck->mstockcardgoodsid)->first()->mcogslastcogs;
            array_push($stocks,$stck);
        }

        return response()->json($stocks);
    }
}
