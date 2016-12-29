<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use Auth;

class LedgerController extends Controller
{
    public function ledger(){
        $data['active'] = 'ledger';
        $data['section'] = 'Buku Besar';
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.ledgerreport',$data);
    }
}
