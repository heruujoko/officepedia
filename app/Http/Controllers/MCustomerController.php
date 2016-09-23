<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MCustomerController extends Controller
{
	public function index(){
		$data['active'] = 'customer';
		$data['section'] = 'customer';
		$data['activetab'] = 1;
		$data['id'] = null;
	    return view('admin/viewmcustomer',$data);
	}
	public function editmcustomercontact($id, $activetab){
		$data['active'] = 'customer';
		$data['section'] = 'customer';
		$data['activetab'] = $activetab;
		$data['id'] = $id;
	    return view('admin/viewmcustomer',$data);		
	}


}
