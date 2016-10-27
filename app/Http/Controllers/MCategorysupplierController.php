<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCategorysupplier;
use Excel;
use PDF;
class MCategorysupplierController extends Controller
{
    public function index(){
    	$data['active'] = 'categorysupllier';
		$data['section'] = 'Kategori Supplier';
    	$data['activetab'] = 1;
		$data['MCategorysupplier'] = MCategorysupplier::all();
		$data['id'] = null;
	  return view('admin/viewmcategorysupplier',$data);
	}

	public function csv(){
		$this->mcategory = MCategorysupplier::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Supplier',function($excel){
			$excel->sheet('Master Kategori Supplier',function($sheet){
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
		$this->mcategory = MCategorysupplier::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Supplier',function($excel){
			$excel->sheet('Master Kateori Supplier',function($sheet){
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
		$data['mcategory'] = MCategorysupplier::where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mcategory',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master Kategori Supplier.pdf');
	}
}
