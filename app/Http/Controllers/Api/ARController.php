<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MARCard;
use Auth;
use App\MCUSTOMER;

class ARController extends Controller
{
    public function ardata(Request $request){

        $ap_query = MARCard::on(Auth::user()->db_name)->where('void',0)->having('marcardoutstanding','>',0);

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

    public function arcustomer($customer_id){
        $cust = MCUSTOMER::on(Auth::user()->db_name)->where('id',$customer_id)->first();
        $group_customer_ar = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$cust->mcustomerid)->groupBy('marcardtransno')->get();
        $customer_per_ar = [];
        foreach($group_customer_ar as $ar){
            $ars = MARCard::on(Auth::user()->db_name)->where('marcardtransno',$ar->marcardtransno)->get();
            $paid =0;
            foreach($ars as $detail){
                $paid += $detail->marcardpayamount;
            }
            $ar['paid_total'] = $paid;
            $ar['outstanding_total'] = $ar->marcardtotalinv - $paid;

            array_push($customer_per_ar,$ar);

        }

        return response()->json($customer_per_ar);
    }
}
