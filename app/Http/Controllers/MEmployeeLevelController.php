<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MEmployeeLevel;
use Excel;
use PDF;

class MEmployeeLevelController extends Controller
{
    public function index(){
      $data['active'] = 'memployeelevel';
      $data['section'] = 'Master Level Karyawan';
      return view('admin.viewmemployeelevel',$data);
    }

    public function csv(){
  		$this->mcategory = MEmployeeLevel::where('void',0)->get();
  		$this->count = 0;
  		return Excel::create('Master Level Karyawan',function($excel){
  			$excel->sheet('Master Level Karyawan',function($sheet){
  				$this->count++;
  				$sheet->row($this->count,array(
  					'Nama Level','Keterangan'
  				));
  				foreach($this->mcategory as $cust){
  					$this->count++;
  					$sheet->row($this->count,array(
  						$cust->level,$cust->information
  					));
  				}
  			});
  		})->export('csv');
  	}
  	public function excel(){
  		$this->mcategory = MEmployeeLevel::where('void',0)->get();
  		$this->count = 0;
  		return Excel::create('Master Level Karyawan',function($excel){
  			$excel->sheet('Master Level Karyawan',function($sheet){
  				$this->count++;
  				$sheet->row($this->count,array(
  				'Nama Level','Keterangan'
  				));
  				foreach($this->mcategory as $cust){
  					$this->count++;
  					$sheet->row($this->count,array(
  						$cust->level,$cust->information
  					));
  				}
  			});
  		})->export('xlsx');
  	}

  	public function pdf(){
  		$data['mcategory'] = MEmployeeLevel::where('void',0)->get();
  		$pdf = PDF::loadview('admin/export/memployeelevelpdf',$data);
  		return $pdf->setPaper('a4', 'potrait')->download('Master Level Karyawan.pdf');
  	}
}
