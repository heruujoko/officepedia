<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MConfig;
use Auth;
use App\Http\Requests;

class APReportController extends Controller
{
    public function apreport(Request $request){
        $data['active'] = 'apreport';
        $data['section'] = 'Laporan Hutang Dagang';
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.apreport',$data);
    }
}
