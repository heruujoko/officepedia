<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCategorygoods;
use Excel;
use PDF;
class MCategorygoodsController extends Controller
{
	public function index(){
    	$data['active'] = 'categorygoods';
		$data['section'] = 'Kategori Barang';
    	$data['activetab'] = 1;
		$data['MCategorygoods'] = MCategorygoods::all();
		$data['id'] = null;
	  return view('admin/viewmcategorygoods',$data);
	}

	public function csv(){
		$this->mcategory = MCategorygoods::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Barang',function($excel){
			$excel->sheet('Master Kategori Aset Tetap',function($sheet){
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
		$this->mcategory = MCategorygoods::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Barang',function($excel){
			$excel->sheet('Master Kateori Barang',function($sheet){
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
		})->export('xls');
	}
	public function pdf(){
		$data['mcategory'] = MCategorygoods::where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mcategory',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master Kategori Barang.pdf');
	}
}

