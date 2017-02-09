<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MARCard;
use App\MBRANCH;
use App\MWarehouse;
use Carbon\Carbon;

class ARBookController extends Controller
{
    public function index(Request $request){
        // header only

        //fetch warehouses
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();

        $warehouses = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$branch->mbranchcode)->get();

        $warehouse_ids = array_map(function($w){
            return $w['id'];
        },$warehouses->toArray());

        $header_query = MARCard::on(Auth::user()->db_name)
        ->whereIn('marcardwarehouseid',$warehouse_ids)
        ->where('void',0)
        ->where('marcardpayamount','>',0);

        if($request->has('customer')){
            $header_query->where('marcardcustomerid',$request->customer);
        }

        $ars = $header_query->groupBy('marcardcustomerid')->get();

        foreach($ars as $ar){
            $ar['header'] = true;
            $ar['data'] = false;
            $ar['footer'] = false;
            $ar->marcardtotalinv = 0;
            $ar->marcardpayamount = 0;
            $ar->marcardoutstanding = 0;
            $pays = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$ar->marcardcustomerid)->where('void',0)->where('marcardpayamount','>',0)->orderBy('marcardtransno','asc')->get();
            $current_inv = "";
            foreach($pays as $p){
                if($p->marcardtransno != $current_inv){
                    $ar->marcardtotalinv += $p->marcardtotalinv;
                    $current_inv = $p->marcardtransno;
                }
                $ar->marcardpayamount += $p->marcardpayamount;
                $ar->marcardoutstanding += $p->marcardoutstanding;
            }

        }

        return response()->json($ars);
    }

    public function details($customer_id){
        $pays = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$customer_id)->where('void',0)->where('marcardpayamount','>',0)->orderBy('created_at','asc')->get();

        foreach ($pays as $p) {
            $p['header'] = false;
            $p['data'] = true;
            $p['footer'] = false;

            $p['inv_date'] = MARCard::on(Auth::user()->db_name)->where('marcardpayamount',0)->where('marcardtransno',$p->marcardtransno)->first()->marcarddate;

            if($p->marcardpayamount == $p->marcardtotalinv){
                $p['aging'] = 'Lunas';
            } else {
                $now = Carbon::now();
                $due = Carbon::parse($p->marcardduedate);
                $diff = $now->diffInDays($due,false);

                $p['aging'] = $diff.' Hari';
            }
        }

        $footer = [
            'header' => false,
            'data' => false,
            'footer' => true,
        ];

        $pays->push($footer);

        return response()->json($pays);
    }
}
