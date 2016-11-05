<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\MCategorycustomer;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;

class MCategorycustomerController extends Controller
{
    public function index(){
    	$data['active'] = 'categorycustomer';
		$data['section'] = 'Kategori Pelanggan';
    	$data['activetab'] = 1;
		$data['MCategorycustomer'] = MCategorycustomer::on(Auth::user()->db_name)->get();
		$data['id'] = null;
	  	return view('admin/viewmcategorycustomer',$data);
	}

	public function csv(){
		$this->mcategory = MCategorycustomer::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Pelanggan',function($excel){
			$excel->sheet('Master Kategori Pelanggan',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Nama Kategori','Barcode'
				));
				foreach($this->mcategory as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->category_name,$cust->information
					));
				}
			});
		})->export('csv');
	}
	public function excel(){
		$this->mcategory = MCategorycustomer::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Pelanggan',function($excel){
			$excel->sheet('Master Kategori Pelanggan',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
				'Nama Kategori','Barcode'
				));
				foreach($this->mcategory as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->category_name,$cust->information
					));
				}
			});
		})->export('xlsx');
	}
	public function pdf(){
		$data['mcategory'] = MCategorycustomer::on(Auth::user()->db_name)->where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mcategory',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master Kategori Pelanggan.pdf');
	}
}
