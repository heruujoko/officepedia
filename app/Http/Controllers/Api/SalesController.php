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
use App\MWarehouse;
use App\MBRANCH;
use App\UserBranch;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index(Request $request){
        $sales = [];
        $headers=[];
        $mhinvoicesubtotal_sum = 0;
        $mhinvoicediscounttotal_sum = 0;
        $mhinvoicetaxtotal_sum = 0;
        $mhinvoicegrandtotal_sum = 0;
        $warehouse_ids = [];
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

        if(!$request->has('wh')){
            // branch filter
            $branch_ids = UserBranch::on(Auth::user()->db_name)->where('userid',Auth::user()->id)->get();
            $branches = collect();
            foreach($branch_ids as $br){
                $br = MBRANCH::on(Auth::user()->db_name)->where('id',$br->branchid)->first();
                $branches->push($br);
            }

            foreach ($branches as $br) {
                $wh = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$br->mbranchcode)->get();
                foreach($wh as $w){
                    array_push($warehouse_ids,$w->id);
                }
            }
        }

        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)
                ->where('mdinvoicedate',$s->mhinvoicedate)
                ->where('mdinvoicegoodsid',$request->goods)
                ->where('mdinvoicegoodsidwhouse',$request->wh)
                ->get();
                $s['detail_count'] = count($details);
                $s['numoftrans'] = count($details);
                $s['header'] = true;
                foreach($details as $dt){

                        $mhinvoicesubtotal_sum += $dt->mdinvoicegoodsgrossamount;
                        $mhinvoicediscounttotal_sum += $dt->mdinvoicegoodsdiscount;
                        $mhinvoicetaxtotal_sum += $dt->mdinvoicegoodstax;
                        $mhinvoicegrandtotal_sum += ($dt->mdinvoicegoodsgrossamount + $dt->mdinvoicegoodstax);

                }

                $s['mhinvoicesubtotal_sum'] = $mhinvoicesubtotal_sum;
                $s['mhinvoicediscounttotal_sum'] = $mhinvoicediscounttotal_sum;
                $s['mhinvoicetaxtotal_sum'] = $mhinvoicetaxtotal_sum;
                $s['mhinvoicegrandtotal_sum'] = $mhinvoicegrandtotal_sum;
            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')->get();
            foreach($sales as $s){

                $mhinvoicesubtotal_sum = 0;
                $mhinvoicediscounttotal_sum = 0;
                $mhinvoicetaxtotal_sum = 0;
                $mhinvoicegrandtotal_sum = 0;

                $details = MDInvoice::on(Auth::user()->db_name)
                ->where('mdinvoicedate',$s->mhinvoicedate)
                ->where('mdinvoicegoodsidwhouse',$request->wh)
                ->get();
                $s['detail_count'] = count($details);
                $s['numoftrans'] = count($details);
                $s['header'] = true;
                foreach($details as $dt){

                        $mhinvoicesubtotal_sum += $dt->mdinvoicegoodsgrossamount;
                        $mhinvoicediscounttotal_sum += $dt->mdinvoicegoodsdiscount;
                        $mhinvoicetaxtotal_sum += $dt->mdinvoicegoodstax;
                        $mhinvoicegrandtotal_sum += ($dt->mdinvoicegoodsgrossamount + $dt->mdinvoicegoodstax);

                }

                $s['mhinvoicesubtotal_sum'] = $mhinvoicesubtotal_sum;
                $s['mhinvoicediscounttotal_sum'] = $mhinvoicediscounttotal_sum;
                $s['mhinvoicetaxtotal_sum'] = $mhinvoicetaxtotal_sum;
                $s['mhinvoicegrandtotal_sum'] = $mhinvoicegrandtotal_sum;

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)
            ->whereDate('mdinvoicedate','>=',Carbon::parse($request->start))
            ->whereDate('mdinvoicedate','<=',Carbon::parse($request->end))
            ->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')->get();
            foreach($sales as $s){
                $mhinvoicesubtotal_sum = 0;
                $mhinvoicediscounttotal_sum = 0;
                $mhinvoicetaxtotal_sum = 0;
                $mhinvoicegrandtotal_sum = 0;

                $details = MDInvoice::on(Auth::user()->db_name)
                ->where('mdinvoicedate',$s->mhinvoicedate)
                ->where('mdinvoicegoodsid',$request->goods)
                ->whereIn('mdinvoicegoodsidwhouse',$warehouse_ids)
                ->get();
                $s['detail_count'] = count($details);
                $s['numoftrans'] = count($details);
                $s['header'] = true;
                foreach($details as $dt){

                        $mhinvoicesubtotal_sum += $dt->mdinvoicegoodsgrossamount;
                        $mhinvoicediscounttotal_sum += $dt->mdinvoicegoodsdiscount;
                        $mhinvoicetaxtotal_sum += $dt->mdinvoicegoodstax;
                        $mhinvoicegrandtotal_sum += ($dt->mdinvoicegoodsgrossamount + $dt->mdinvoicegoodstax);

                }

                $s['mhinvoicesubtotal_sum'] = $mhinvoicesubtotal_sum;
                $s['mhinvoicediscounttotal_sum'] = $mhinvoicediscounttotal_sum;
                $s['mhinvoicetaxtotal_sum'] = $mhinvoicetaxtotal_sum;
                $s['mhinvoicegrandtotal_sum'] = $mhinvoicegrandtotal_sum;
            }
        } else {
            $sales = $header_query->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum,count(mhinvoiceno) as numoftrans')
            ->get();

            foreach($sales as $s){
                $details = MDInvoice::on(Auth::user()->db_name)->whereIn('mdinvoicegoodsidwhouse',$warehouse_ids)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);
                $s['numoftrans'] = count($details);
                $s['header'] = true;
                $s['mhinvoicesubtotal_sum'] = 0;
                $s['mhinvoicediscounttotal_sum'] = 0;
                $s['mhinvoicetaxtotal_sum'] = 0;
                $s['mhinvoicegrandtotal_sum'] = 0;
                foreach($details as $dt){
                    $s['mhinvoicesubtotal_sum'] += $dt->mdinvoicegoodsgrossamount;
                    $s['mhinvoicediscounttotal_sum'] += $dt->mdinvoicegoodsdiscount;
                    $s['mhinvoicetaxtotal_sum'] += $dt->mdinvoicegoodstax;
                    $s['mhinvoicegrandtotal_sum'] += $dt->mdinvoicegoodsgrossamount + $dt->mdinvoicegoodstax;
                }
            }
        }

        return response()->json($sales);
    }

    public function invoice_detail(Request $request,$invoice_date){
        $warehouse_ids = [];
        $detail_query = MDInvoice::on(Auth::user()->db_name)->whereDate('mdinvoicedate','=',Carbon::parse($invoice_date))->where('void',0)->orderBy('mhinvoiceno','asc');
        if($request->has('goods')){
            $detail_query->where('mdinvoicegoodsid',$request->goods);
        }
        if($request->has('wh')){
            $detail_query->where('mdinvoicegoodsidwhouse',$request->wh);
        } else {
            // branch filter
            $branch_ids = UserBranch::on(Auth::user()->db_name)->where('userid',Auth::user()->id)->get();
            $branches = collect();
            foreach($branch_ids as $br){
                $br = MBRANCH::on(Auth::user()->db_name)->where('id',$br->branchid)->first();
                $branches->push($br);
            }

            foreach ($branches as $br) {
                $wh = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$br->mbranchcode)->get();
                foreach($wh as $w){
                    array_push($warehouse_ids,$w->id);
                }
            }
            $detail_query->whereIn('mdinvoicegoodsidwhouse',$warehouse_ids);
        }
        $details = $detail_query->get();
        foreach ($details as $d) {
            $md = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$d->mhinvoiceno)->where('void',0)->get();
            $d['header'] = false;
            $d['numoftrans'] = count($md);
            $d['mhinvoicesubtotal_sum'] = $d->mdinvoicegoodsgrossamount;
            $d['mhinvoicetaxtotal_sum'] = $d->mdinvoicegoodstax;
            $d['mhinvoicegrandtotal_sum'] = $d->mdinvoicegoodsgrossamount + $d->mdinvoicegoodstax;
        }
        return response()->json($details);
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

        $queries = MDInvoice::on(Auth::user()->db_name)->where('void',0);
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

        $active_branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();

        // get all warehouses in branch
        $warehouses = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$active_branch->mbranchcode)->get();
        $warehouse_ids = array_map(function($w){
            return $w['id'];
        },$warehouses->toArray());

        $header_query = MARCard::on(Auth::user()->db_name)->where('void',0)->whereIn('marcardwarehouseid',$warehouse_ids);

        if($request->has('cust')){
            $header_query->where('marcardcustomerid',$request->cust);
        }
        if($request->has('end')){
            $header_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        $ars = $header_query->orderBy('marcardcustomerid','asc')->groupBy('marcardcustomerid')->get();

        foreach($ars as $ar){
            $ar['header'] = true;
            $ar['data'] = false;
            $ar['footer'] = false;
            $ar['numoftrans'] = 0;
            $ar['1w'] = 0;
            $ar['2w'] = 0;
            $ar['3w'] = 0;
            $ar['4w'] = 0;
            $ar['1m'] = 0;
            $ar->marcardtotalinv = 0;
            $ar->marcardoutstanding = 0;
            $details = MARCard::on(Auth::user()->db_name)->whereIn('marcardwarehouseid',$warehouse_ids)->where('marcardcustomerid',$ar->marcardcustomerid)->where('void',0)->get();
            foreach($details as $d){
                $ar['numoftrans'] += 1;
                $now = Carbon::now();
                $due = Carbon::parse($d->marcardduedate);
                $diff = $now->diffInDays($due,false);

                $ar->marcardtotalinv += $d->marcardtotalinv;
                $ar->marcardoutstanding += $d->marcardoutstanding;

                // spread the ar in weeks
                if($diff > 0 && $diff <= 7){
                    $ar['1w'] += $d->marcardoutstanding;
                }
                if($diff > 7 && $diff <= 14){
                    $ar['2w'] += $d->marcardoutstanding;
                }
                if($diff > 14 && $diff <= 21){
                    $ar['3w'] += $d->marcardoutstanding;
                }
                if($diff > 21 && $diff <= 30){
                    $ar['4w'] += $d->marcardoutstanding;
                }
                if($diff > 30){
                    $ar['1m'] += $d->marcardoutstanding;
                }
            }
        }

        return response()->json($ars);
    }

    public function arcust_detail(Request $request,$customer_id){
        $active_branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();

        // get all warehouses in branch
        $warehouses = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$active_branch->mbranchcode)->get();
        $warehouse_ids = array_map(function($w){
            return $w['id'];
        },$warehouses->toArray());

        $detail_query = MARCard::on(Auth::user()->db_name)->whereIn('marcardwarehouseid',$warehouse_ids)->where('void',0)->where('marcardcustomerid',$customer_id);

        if($request->has('end')){
            $detail_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }

        $details = $detail_query->get();

        foreach($details as $d){
            $d['header'] = false;
            $d['data'] = true;
            $d['footer'] = false;
            $d['numoftrans'] = 0;
            $d['1w'] = 0;
            $d['2w'] = 0;
            $d['3w'] = 0;
            $d['4w'] = 0;
            $d['1m'] = 0;

            $now = Carbon::now();
            $due = Carbon::parse($d->marcardduedate);
            $diff = $now->diffInDays($due,false);
            $d['aging'] = $diff;
            // spread the ar in weeks
            if($diff > 0 && $diff <= 7){
                $d['1w'] += $d->marcardoutstanding;
            }
            if($diff > 7 && $diff <= 14){
                $d['2w'] += $d->marcardoutstanding;
            }
            if($diff > 14 && $diff <= 21){
                $d['3w'] += $d->marcardoutstanding;
            }
            if($diff > 21 && $diff <= 30){
                $d['4w'] += $d->marcardoutstanding;
            }
            if($diff > 30){
                $d['1m'] += $d->marcardoutstanding;
            }

        }

        $footer = [
            'header' => false,
            'data' => false,
            'footer' => true
        ];

        $details->push($footer);

        return response()->json($details);

    }
}
