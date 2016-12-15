<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HPPHistory;
use Auth;
use Carbon\Carbon;
use App\MGoods;

class COGSHistoryController extends Controller
{
    public function index(Request $request){

        $history_query = HPPHistory::on(Auth::user()->db_name);

        if($request->has('goods')){
            $history_query->where('hpphistorygoodsid',$request->goods);
        }

        if($request->has('end')){
            $history_query->whereDate('created_at','<=',Carbon::parse($request->end));
        }

        $histories = $history_query->get();

        foreach($histories as $h){
            $h['goodsname'] = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$h->hpphistorygoodsid)->first()->mgoodsname;
        }

        return response()->json($histories);

    }
}
