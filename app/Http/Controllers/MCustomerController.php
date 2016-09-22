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

	public function store(){
		$new_cust = new MCust;
		$new_cust->name = $request->name;
		$new_cust->save();
		if($request->chk){
			$prefix = MPrefix::where('type','Master Customer')->first();
			$new_cust->id_pelanggan = $prefix->name.'-'.$prefix->last_count;
			$prefix->last_count++;
			$new_cust->save();
			$prefix->save();
		} else {
			$new_cust->id_pelanggan = $request->id_pelanggan;
			$new_cust->save();
		}

	}
}
