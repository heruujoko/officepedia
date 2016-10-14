<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MGoods;
use Excel;
use PDF;

class MGoodsController extends Controller
{
    public function index(){
		$data['active'] = 'barang';
		return view('admin/viewbarang',$data);
	}
}
