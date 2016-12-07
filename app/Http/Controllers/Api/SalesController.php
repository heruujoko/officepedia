<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MHInvoice;
use App\MDInvoice;
use App\MConfig;
use App\MARCard;

use Carbon\Carbon;

class SalesController extends Controller
{
    public function index(Request $request){
        $sales = [];
        $headers=[];

        /*
         * filter date header
         */
        $header_query = MHInvoice::on(Auth::user()->db_name);
        if($request->has('start')){
            $header_query->whereDate('mhinvoicedate','>=',Carbon::parse($request->start));
        }
        if($request->has('end')){
            $header_query->whereDate('mhinvoicedate','<=',Carbon::parse($request->end));
        }

        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum,count(mhinvoiceno) as numoftrans')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum,count(mhinvoiceno) as numoftrans')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum,count(mhinvoiceno) as numoftrans')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = $header_query->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum,count(mhinvoiceno) as numoftrans')
            ->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }

        return response()->json($sales);
    }

    public function invoices(Request $request){

        /*
         * price config
         */
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        /*
         * filterings
         */

        $queries = MDInvoice::on(Auth::user()->db_name);
        if($request->has('start')){
            $queries->whereDate('mdinvoicedate','>=',Carbon::parse($request->start));
        }

        if($request->has('end')){
            $queries->whereDate('mdinvoicedate','<=',Carbon::parse($request->end));
        }

        if($request->has('goods') && $request->has('wh') != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
        } else if($request->has('goods') && $request->goods != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->get();
        } else if($request->has('wh') && $request->wh != "" ){
            $invs = $queries->where('mdinvoicegoodsidwhouse',$request->wh)->get();
        } else {
            $invs = $queries->get();
        }
        $dates = [];
        foreach($invs as $i){
            array_push($dates,$i->mdinvoicedate);
        }
        $dates = array_unique($dates);
        $date_group_invoices = [];
        foreach ($dates as $dt) {
            array_push($date_group_invoices,['date' => $dt,'mdinvoicegoodsprice' => ""]);
            /*
             * filterings
             */

            if($request->has('goods') && $request->has('wh') != ""){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
            } else if($request->has('goods') && $request->goods != ""){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('void',0)->get();
            } else if($request->has('wh') && $request->wh != "" ){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
            } else {
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('void',0)->get();
            }
            foreach ($inv as $iv) {
                $iv['price'] = number_format($iv->mdinvoicegoodsprice,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['disc'] = number_format($iv->mdinvoicegoodsdiscount,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['tax'] = number_format($iv->mdinvoicegoodstax,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['sub'] = number_format($iv->mdinvoicegoodsgrossamount ,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['total'] = number_format(($iv->mdinvoicegoodsgrossamount + $iv->mdinvoicegoodstax - $iv->mdinvoicegoodsdiscount) ,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                array_push($date_group_invoices,$iv);
            }
        }
        return response()->json($date_group_invoices);
    }

    public function ar(Request $request){
        $queries = MARCard::on(Auth::user()->db_name);
        if($request->has('end')){
            $queries->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        if($request->has('cust')){
            $queries->where('marcardcustomerid',$request->cust);
        }

        // $ars = $queries->get();
        $ars = $queries->groupBy('marcardcustomerid')
        ->selectRaw('* , sum(marcardoutstanding) as marcardoutstanding_sum')
        ->get();

        /*
         * groupping ars
         */
        $marcardoutstanding_total = 0;
        $trans_count_total = 0;
        $seven_total = 0;
        $fourteen_total = 0;
        $twentyone_total = 0;
        $thirty_total = 0;
        $month_total = 0;

        foreach($ars as $ar){
            $marcardoutstanding_total += $ar->marcardoutstanding_sum;
            $now = Carbon::now();
            $due = Carbon::parse($ar->marcardduedate);
            $diff = $now->diffInDays($due,false);
            $ar['trans_count'] = count(MHInvoice::on(Auth::user()->db_name)->where('mhinvoicecustomerid',$ar->marcardcustomerid)->get());
            if($diff > 0){
                if($diff <= 7){
                    $ar['seven'] = $ar->marcardoutstanding_sum;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $seven_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 14){
                    $ar['seven'] = 0;
                    $ar['fourteen'] = $ar->marcardoutstanding_sum;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $fourteen_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 21){
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] = $ar->marcardoutstanding_sum;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $twentyone_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 30){
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] = $ar->marcardoutstanding_sum;
                    $ar['month'] =0;
                    $thirty_total += $ar->marcardoutstanding_sum;
                } else {
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] = $ar->marcardoutstanding_sum;
                    $month_total += $ar->marcardoutstanding_sum;
                }
            } else {
                $ar['seven'] = 0;
                $ar['fourteen'] =0;
                $ar['twentyone'] =0;
                $ar['thirty'] =0;
                $ar['month'] = 0;
                $month_total += 0;
            }

        }
        return response()->json($ars);
    }

    public function arcust(Request $request){

        /*
         * price config
         */
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['thousands_sep'] = $config->msysnumseparator;
        if($data['thousands_sep'] == ","){
          $data['dec_point'] = ".";
        } else {
          $data['dec_point'] = ",";
        }

        $header_query = MARCard::on(Auth::user()->db_name);
        if($request->has('cust')){
            $header_query->where('marcardcustomerid',$request->cust);
        }
        if($request->has('end')){
            $header_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        $headers = $header_query->get();
        $customers = [];
        foreach($headers as $h){
            array_push($customers,$h->marcardcustomerid);
        }
        $customers = array_unique($customers);

        $ar_detail_data = [];

        /*
         * Build detail data per customer head
         */
         $idx=0;
        foreach ($customers as $cust) {
            $detail_query = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$cust);
            if($request->has('end')){
                $detail_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
            }
            $details = $detail_query->get();

            array_push($ar_detail_data,['customerid' => $cust,'customername' => $details[$idx]->marcardcustomername]);
            foreach($details as $dt){
                $dt['outstanding_prc'] = number_format($dt->marcardoutstanding,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $dt['aging'] = Carbon::now()->diffInDays(Carbon::parse($dt->marcarddate));
                $dt['trans_count'] = count(MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$dt->marcardtransno)->get());
                array_push($ar_detail_data,$dt);
            }
            $idx++;
        }

        return response()->json($ar_detail_data);
    }
}
