<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;
use App\MHPayAr;
use PDF;
use Excel;

class PayArController extends Controller
{
    public function payar(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'payar';
        $data['section'] = 'Pembayaran Piutang Dagang';
        return view('admin.payar',$data);
    }
}
