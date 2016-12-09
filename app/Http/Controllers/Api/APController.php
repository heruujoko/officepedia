<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MAPCard;
use Carbon\Carbon;
use Auth;

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

        $headers = $header_query->groupBy('mapcardsupplierid')->orderBy('created_at')->get();
        $dates = [];
        foreach($headers as $hd){
            array_push($dates,array('mapcardsupplierid' => $hd->mapcardsupplierid,'mapcardsuppliername' => $hd->mapcardsuppliername));
        }
        $reports = [];
        foreach($dates as $d){
            $h = array(
                'data' => false,
                'mapcardsupplierid' => $d['mapcardsupplierid'],
                'mapcardsuppliername' => $d['mapcardsuppliername'],
            );
            array_push($reports,$h);
            $dtl_query = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$d['mapcardsupplierid'])->orderBy('created_at');
            if($request->has('br')){

            }

            if($request->has('spl')){
                $dtl_query->where('mapcardsupplierid',$request->spl);
            }

            if($request->has('end')){
                $dtl_query->whereDate('mapcardtdate','<=',Carbon::parse($request->end));
            }

            $dtl = $dtl_query->get();

            foreach ($dtl as $dt) {
                $dt['data'] = true;
                $dt['aging'] = Carbon::parse($dt->mapcardtdate)->diffInDays(Carbon::now());
                array_push($reports,$dt);
            }
        }

        return response()->json($reports);
    }
}
