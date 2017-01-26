<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;

class CashBankIncomeController extends Controller
{
    public function index(){

        if(Auth::user()->has_role('R_cashbankincome')){
            $data['section'] = "Penerimaan Kas / Bank";
            $data['active'] = "cashbankincome";
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            return view('admin.cashbankincome',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }
}
