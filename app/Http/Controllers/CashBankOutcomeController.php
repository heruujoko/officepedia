<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;


class CashBankOutcomeController extends Controller
{
    public function index(){

        if(Auth::user()->has_role('R_cashbankoutcome')){
            $data['section'] = "Pengeluaran Kas / Bank";
            $data['active'] = "cashbankoutcome";
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            return view('admin.cashbankoutcome',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }
}
