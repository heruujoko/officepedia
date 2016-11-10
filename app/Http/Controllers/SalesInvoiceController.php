<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MCUSTOMER;
use App\MGoods;
use App\MUnit;
use App\MTax;
use App\MWarehouse;
use Auth;
use App\Http\Requests;

class SalesInvoiceController extends Controller
{
    public function index(){
      $data['active'] = 'salesinvoice';
      $data['section'] = 'Transaksi Faktur Penjualan';
      $data['customers'] = MCUSTOMER::on(Auth::user()->db_name)->get();
      $data['goods'] = MGoods::on(Auth::user()->db_name)->get();
      $data['units'] = MUnit::on(Auth::user()->db_name)->get();
      $data['taxes'] = MTax::on(Auth::user()->db_name)->get();
      $data['whouses'] = MWarehouse::on(Auth::user()->db_name)->get();
      return view('admin.salesinvoicevue',$data);
    }
}
