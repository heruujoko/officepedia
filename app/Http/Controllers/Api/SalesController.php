<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MHInvoice;
use App\MDInvoice;

class SalesController extends Controller
{
    public function index(Request $request){
        $sales = [];
        $headers=[];
        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = MHInvoice::on(Auth::user()->db_name)->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        }

        return response()->json($sales);
    }
}
