<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MConfig;
use Auth;
use App\Http\Requests;

class PurchaseController extends Controller
{
    public function index(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'purchase';
        $data['section'] = 'Transaksi Pembelian';
        return view('admin.purchaseinvoice',$data);
    }
}
