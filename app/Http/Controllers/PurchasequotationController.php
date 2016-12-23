<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\MConfig;

Use Auth;
class PurchasequotationController extends Controller
{
    public function index(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'purchaseinvoice';
        $data['section'] = 'Transaksi Pembelian';
        return view('admin.purchasequotation',$data);
    }
}
