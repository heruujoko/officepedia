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

      $invoice_header = new MHInvoice;
      $invoice_header->setConnection(Auth::user()->db_name);
      $invoice_header->mhinvoicedate = Carbon::parse($request->date);
      $invoice_header->mhinvoicesubtotal = $request->subtotal;
      $invoice_header->mhinvoicetaxtotal = $request->tax;
      $invoice_header->mhinvoicediscounttotal = $request->discount;
      //set customer data
      $customer = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->customer)->first();
      $invoice_header->mhinvoicecustomerid = $customer->mcustomerid;
      $invoice_header->mhinvoicecustomername = $customer->mcustomername;
      $invoice_header->save();
      var_dump($request->discount);
    }
}
