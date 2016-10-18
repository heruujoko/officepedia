<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MGoodsMark;
use App\Http\Requests;
use Excel;
use PDF;
class MGoodsMarkController extends Controller
{
    public function index(){
      $data['active'] = 'mgoodsmark';
      $data['section'] = 'Kategori Merek Barang';
      return view('admin/viewmgoodsmark',$data);
    }

    public function csv(){
  		$this->mcategory = MGoodsMark::where('void',0)->get();
  		$this->count = 0;
  		return Excel::create('Master Kategori Merek Barang',function($excel){
  			$excel->sheet('Master Kategori Merek Barang',function($sheet){
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
  		$this->mcategory = MGoodsMark::where('void',0)->get();
  		$this->count = 0;
  		return Excel::create('Master Kategori Merek Barang',function($excel){
  			$excel->sheet('Master Kateori Merek Barang',function($sheet){
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
  		$data['mcategory'] = MGoodsMark::where('void',0)->get();
  		$pdf = PDF::loadview('admin/export/mcategory',$data);
  		return $pdf->setPaper('a4', 'potrait')->download('Master Kategori Merek Barang.pdf');
  	}
}
