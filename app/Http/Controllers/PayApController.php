<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;

class PayApController extends Controller
{
    public function payap(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'payap';
        $data['section'] = 'Pembayaran Hutang Dagang';
        return view('admin.payap',$data);
    }
}
