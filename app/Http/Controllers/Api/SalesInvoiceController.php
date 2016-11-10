<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHInvoice;
use App\MDInvoice;
use App\MCUSTOMER;
use Auth;
use Carbon\Carbon;

class SalesInvoiceController extends Controller
{
    public function store(Request $request){

      // $invoice_header = new MHInvoice;
      // $invoice_header->setConnection(Auth::user()->db_name);
      // $invoice_header->mhinvoicedate = Carbon::parse($request->date);
      // $invoice_header->mhinvoicesubtotal = $request->subtotal;
      // $invoice_header->mhinvoicetaxtotal = $request->tax;
      // $invoice_header->mhinvoicediscounttotal = $request->discount;
      // //set customer data
      // $customer = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->mcustomerid)->first();
      // $invoice_header->mhinvoicecustomerid = $customer->mcustomerid;
      // $invoice_header->mhinvoicecustomername = $customer->mcustomername;
      // $invoice_header->save();
      // // dd($request->goods[0]['goods']['mgoodscode']);
      // $header = MHInvoice::on(Auth::user()->db_name)->where('id',$invoice_header->id)->first();
      // foreach($request->goods as $g){
      //   $invoice_detail = new MDInvoice;
      //   $invoice_detail->setConnection(Auth::user()->db_name);
      //   $invoice_detail->mhinvoiceno = $header->mhinvoiceno;
      //   $invoice_detail->mdcustomerid = $customer->mcustomerid;
      //   $invoice_detail->mdcustomername = $customer->mcustomername;
      //   $invoice_detail->mdinvoicedate = $header->mhinvoicedate;
      //   $invoice_detail->mdinvoicegoodsid = $g['goods']['mgoodscode'];
      //   $invoice_detail->mdinvoicegoodsname = $g['goods']['mgoodsname'];
      //   $invoice_detail->mdinvoicegoodsqty = $g['usage'];
      //   $invoice_detail->save();
      // }

      $transcation = MHInvoice::start_transaction($request);
      if($transcation != true){
          return response()->json($transcation);
      } else {
          return response()->json($transcation,400);
      }


    }
}
