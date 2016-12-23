<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MARCard;
use Auth;

class ARController extends Controller
{
    public function ardata(Request $request){

        $ap_query = MARCard::on(Auth::user()->db_name)->having('marcardoutstanding','>',0);

        if($request->has('spl')){
            $ap_query->where('marcardsupplierid',$request->spl);
        }

        $apgroup = $ap_query->groupBy('marcardtransno')->get();

        $apdata = [];

        foreach ($apgroup as $grp) {
            $ap = MARCard::on(Auth::user()->db_name)->where('marcardtransno',$grp->marcardtransno)->get()->last();
            if($ap->marcardoutstanding > 0){
                array_push($apdata,$ap);
            }

        }

        return response()->json($apdata);

    }
}
