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

        $histories = $history_query->groupBy('hpphistorygoodsid')->get();

        $history_data = [];

        foreach($histories as $h){
            $header = [
                'data' => 'header',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname
            ];
            array_push($history_data,$header);
            $childs_q = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$h->hpphistorygoodsid);
            if($request->has('end')){
                $childs_q->whereDate('created_at','<=',Carbon::parse($request->end));
            }
            $childs = $childs_q->get();
            foreach($childs as $ch){
                $ch['data'] = 'data';
                array_push($history_data,$ch);
            }

            $footer = [
                'data' => 'footer',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname,
                'hpphistoryqty' => $childs->last()->hpphistoryqty,
                'hpphistorycogs' => $childs->last()->hpphistorycogs
            ];
            array_push($history_data,$footer);

        }

        return response()->json($history_data);

    }
}
