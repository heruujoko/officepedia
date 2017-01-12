<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;

class CashBankTransferController extends Controller
{
    public function index(){
        $data['section'] = "Transfer Kas / Bank";
        $data['active'] = "cashbanktransfer";
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.cashbanktransfer',$data);
    }
}
