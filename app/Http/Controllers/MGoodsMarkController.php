<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MGoodsMark;
use App\Http\Requests;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;

class MGoodsMarkController extends Controller
{
    public function index(){

        if(Auth::user()->has_role('R_brands')){
            $data['active'] = 'mgoodsmark';
            $data['section'] = 'Kategori Merek Barang';
            return view('admin/viewmgoodsmark',$data);
        } else {
            return redirect('/admin-nano/index');
        }

    }

    public function csv(){
  		$this->mcategory = MGoodsMark::on(Auth::user()->db_name)->where('void',0)->get();
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
  		$this->mcategory = MGoodsMark::on(Auth::user()->db_name)->where('void',0)->get();
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
  		})->export('xls');
  	}
  	public function pdf(){
  		$data['mcategory'] = MGoodsMark::on(Auth::user()->db_name)->where('void',0)->get();
  		$pdf = PDF::loadview('admin/export/mcategory',$data);
  		return $pdf->setPaper('a4', 'potrait')->download('Master Kategori Merek Barang.pdf');
  	}
}
