<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MAPCard;
use App\MSupplier;
use Carbon\Carbon;
use Auth;
use DB;

class APController extends Controller
{
    public function apreport(Request $request){
        $header_query = MAPCard::on(Auth::user()->db_name);

        if($request->has('br')){

        }

        if($request->has('spl')){
            $header_query->where('mapcardsupplierid',$request->spl);
        }

        if($request->has('end')){
            $header_query->whereDate('mapcardtdate','<=',Carbon::parse($request->end));
        }

        $headers = $header_query->groupBy('mapcardsupplierid')->orderBy('created_at')->where('void',0)->get();
        $dates = [];
        foreach($headers as $hd){
            array_push($dates,array('mapcardsupplierid' => $hd->mapcardsupplierid,'mapcardsuppliername' => $hd->mapcardsuppliername));
        }
        $reports = [];
        foreach($dates as $d){
            $h = array(
                'data' => false,
                'footer' => false,
                'mapcardsupplierid' => $d['mapcardsupplierid'],
                'mapcardsuppliername' => $d['mapcardsuppliername'],
            );
            array_push($reports,$h);
            $dtl_query = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$d['mapcardsupplierid'])->orderBy('created_at')->where('void',0);
            if($request->has('br')){

            }

            if($request->has('spl')){
                $dtl_query->where('mapcardsupplierid',$request->spl);
            }

            if($request->has('end')){
                $dtl_query->whereDate('mapcardtdate','<=',Carbon::parse($request->end));
            }

            $dtl = $dtl_query->get();

            $total_inv = 0;
            $total_outstanding = 0;

            foreach ($dtl as $dt) {
                $dt['data'] = true;
                $dt['aging'] = Carbon::parse($dt->mapcardtdate)->diffInDays(Carbon::now());
                $dt['footer'] = false;
                $total_inv += $dt->mapcardtotalinv;
                if($dt->mapcardpayamount > 0){
                    $total_outstanding -= $dt->mapcardpayamount;
                } else {
                    $total_outstanding += $dt->mapcardoutstanding;
                }
                array_push($reports,$dt);
            }

            $footer = array(
                'footer' => true,
                'total_inv' => $total_inv,
                'total_outstanding' => $total_outstanding
            );
            array_push($reports,$footer);

        }

        return response()->json($reports);
    }

    public function show($id){
        $ap_query = MAPCard::on(Auth::user()->db_name)->where('id',$id)->first();
    }

    public function apdata(Request $request){

        $ap_query = MAPCard::on(Auth::user()->db_name)->where('void',0)->having('mapcardoutstanding','>',0);

        if($request->has('spl')){
            $ap_query->where('mapcardsupplierid',$request->spl);
        }

        $apgroup = $ap_query->groupBy('mapcardtransno')->get();

        $apdata = [];

        foreach ($apgroup as $grp) {
            $ap = MAPCard::on(Auth::user()->db_name)->where('mapcardtransno',$grp->mapcardtransno)->get()->last();
            if($ap->mapcardoutstanding > 0){
                array_push($apdata,$ap);
            }

        }

        return response()->json($apdata);

    }

    public function apsupplier($supplier_id){
        $spl = MSupplier::on(Auth::user()->db_name)->where('id',$supplier_id)->first();
        $group_supplier_ap = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$spl->msupplierid)->groupBy('mapcardtransno')->where('void',0)->get();
        $supplier_per_ap = [];
        foreach($group_supplier_ap as $ap){
            $aps = MAPCard::on(Auth::user()->db_name)->where('mapcardtransno',$ap->mapcardtransno)->where('void',0)->get();
            $paid =0;
            foreach($aps as $detail){
                $paid += $detail->mapcardpayamount;
            }
            $ap['paid_total'] = $paid;
            $ap['outstanding_total'] = $ap->mapcardtotalinv - $paid;

            array_push($supplier_per_ap,$ap);

        }

        return response()->json($supplier_per_ap);
    }
}
