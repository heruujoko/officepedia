<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MStockcardreportController extends Controller
{
    public function index(){
    	$data['active'] = 'stockcardreport';
    	$data['section'] = 'Stock Card Report';
    	return view('admin/viewmstockcardreport',$data);
    }
    
}
