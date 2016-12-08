<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MGoods;
use DB;
use Auth;
use App\Helper\UnitHelper;

class StockValueController extends Controller
{
    public function index(Request $request){
        $query = DB::connection(Auth::user()->db_name)->table('mgoods')
        ->join('mcogs','mgoods.mgoodscode','=','mcogs.mcogsgoodscode');

        if($request->has('spl')){
            $query->where('mgoodssuppliercode',$request->spl);
        }

        if($request->has('goods')){
            $query->where('mgoodscode',$request->goods);
        }

        $stockvalues = $query->orderBy('mgoodscode','asc')->get();
        foreach($stockvalues as $st){
            $st->verbs = UnitHelper::label($st,$st->mgoodsstock);
        }
        return response()->json($stockvalues);
    }
}
