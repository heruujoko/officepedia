<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MStockCard;
use App\MGoods;
use App\MWarehouse;
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
    $data = $query->get();

    return response()->json($data);
  }

}
