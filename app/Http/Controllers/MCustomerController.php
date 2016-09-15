<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MCustomerController extends Controller
{
	public function index(){
	$data['active'] = 'customer';
	$data['section'] = 'customer';
    return view('admin/viewmcustomer',$data);
}
}
