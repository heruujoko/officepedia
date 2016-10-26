<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCategoryfixedassets;
use Excel;
use PDF;

class MCategoryfixedassetsController extends Controller
{
    public function index(){
    	$data['active'] = 'categoryfixedassets';
		$data['section'] = 'Kategori Asset Tetap';
    	$data['activetab'] = 1;
		$data['MCategorygoods'] = MCategoryfixedassets::all();
		$data['id'] = null;
	  return view('admin/viewmcategoryfixedassets',$data);
	}

	public function csv(){
		$this->mcategory = MCategoryfixedassets::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Aset Tetap',function($excel){
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
		$this->mcategory = MCategoryfixedassets::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Aset Tetap',function($excel){
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
		})->export('xlsx');
	}
	public function pdf(){
		$data['mcategory'] = MCategoryfixedassets::where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mcategory',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master Kategori Aset Tetap.pdf');
	}
}
