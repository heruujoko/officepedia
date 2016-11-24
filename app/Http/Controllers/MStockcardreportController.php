<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\MConfig;

use Auth;

class MStockcardreportController extends Controller
{
    public function index(){
    	$data['config'] = MConfig::on(Auth::user()->db_name)->first();
    	$data['active'] = 'stockcardreport';
    	$data['section'] = 'Stock Card Report';
    	return view('admin/viewmstockcardreport',$data);
    }
    
}
