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

        $histories = $history_query->groupBy('hpphistorygoodsid')->where('void',0)->get();

        $history_data = [];

        foreach($histories as $h){
            $header = [
                'data' => 'header',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname
            ];

            $qtys = 0;

            array_push($history_data,$header);
            $childs_q = HPPHistory::on(Auth::user()->db_name)->where('void',0)->where('hpphistorygoodsid',$h->hpphistorygoodsid);
            if($request->has('end')){
                $childs_q->whereDate('created_at','<=',Carbon::parse($request->end));
            }
            $childs = $childs_q->orderBy('created_at','asc')->get();
            foreach($childs as $ch){
                $ch['data'] = 'data';

                if($ch->type == 'purchase'){
                    $qtys += $ch->usage;
                } else {
                    $qtys -= $ch->usage;
                }

                array_push($history_data,$ch);
            }

            $footer = [
                'data' => 'footer',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname,
                'hpphistoryqty' => $qtys,
                'hpphistorycogs' => $childs->last()->hpphistorycogs
            ];
            array_push($history_data,$footer);

        }

        return response()->json($history_data);

    }
}
