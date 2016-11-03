<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCategoryfixedassets;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;

class MCategoryfixedassetsController extends Controller
{
    public function index(){
      DBHelper::configureConnection(Auth::user()->db_alias);
    	$data['active'] = 'categoryfixedassets';
		  $data['section'] = 'Kategori Asset Tetap';
    	$data['activetab'] = 1;
		  $data['MCategorygoods'] = MCategoryfixedassets::on(Auth::user()->db_name)->get();
		  $data['id'] = null;
	    return view('admin/viewmcategoryfixedassets',$data);
	  }

	public function csv(){
    DBHelper::configureConnection(Auth::user()->db_alias);
		$this->mcategory = MCategoryfixedassets::on(Auth::user()->db_name)->where('void',0)->get();
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
    DBHelper::configureConnection(Auth::user()->db_alias);
		$this->mcategory = MCategoryfixedassets::on(Auth::user()->db_name)->where('void',0)->get();
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
    DBHelper::configureConnection(Auth::user()->db_alias);
		$data['mcategory'] = MCategoryfixedassets::on(Auth::user()->db_name)->where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mcategory',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master Kategori Aset Tetap.pdf');
	}
}
