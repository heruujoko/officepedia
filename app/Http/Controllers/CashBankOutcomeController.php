<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;


class CashBankOutcomeController extends Controller
{
    public function index(){
        $data['section'] = "Pengeluaran Kas / Bank";
        $data['active'] = "cashbankoutcome";
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.cashbankoutcome',$data);
    }
}
