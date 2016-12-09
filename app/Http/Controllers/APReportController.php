<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MConfig;
use Auth;
use App\Http\Requests;
use App\MAPCard;
use Carbon\Carbon;

class APReportController extends Controller
{
    public function apreport(Request $request){
        $data['active'] = 'apreport';
        $data['section'] = 'Laporan Hutang Dagang';
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.apreport',$data);
    }

    public function apreport_print(Request $request){
        $header_query = MAPCard::on(Auth::user()->db_name);

        if($request->has('br')){

        }

        if($request->has('spl')){
            $header_query->where('mapcardsupplierid',$request->spl);
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
            $dtl = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$d['mapcardsupplierid'])->orderBy('created_at')->get();
            foreach ($dtl as $dt) {
                $dt['data'] = true;
                $dt['aging'] = Carbon::parse($dt->mapcardtdate)->diffInDays(Carbon::now());
                array_push($reports,$dt);
            }
        }

        $data['aps'] = $reports;
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['spl'] = 'Semua';
        $data['goods'] = 'Semua';
        $data['br'] = 'Semua';
        $data['wh'] = 'Semua';
        $data['end'] = Carbon::now();
        $data['company'] = $data['config']->msyscompname;

        return view('admin.export.apreport',$data);
    }
}
