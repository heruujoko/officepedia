<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MDepartement;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;

class MDepartementController extends Controller
{
    public function index(){
        if(Auth::user()->has_role('R_departement')){
            DBHelper::configureConnection(Auth::user()->db_alias);
          	$data['active'] = 'departement';
      		$data['section'] = 'Departement';
          	$data['activetab'] = 1;
      		$data['MDepartement'] = MDepartement::on(Auth::user()->db_name)->get();
      		$data['id'] = null;
      	    return view('admin/viewmdepartement',$data);
        } else {
            return redirect('/admin-nano/index');
        }
	}

	public function csv(){
    DBHelper::configureConnection(Auth::user()->db_alias);
		$this->mdepartement = MDepartement::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Departement',function($excel){
			$excel->sheet('Master Departement',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Nama Departemen','Barcode'
				));
				foreach($this->mdepartement as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mdepartement_name,$cust->information
					));
				}
			});
		})->export('csv');
	}
	public function excel(){
    DBHelper::configureConnection(Auth::user()->db_alias);
		$this->mdepartement = MDepartement::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Departement',function($excel){
			$excel->sheet('Master Departement',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
				'Nama Departemen','Barcode'
				));
				foreach($this->mdepartement as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mdepartement_name,$cust->information
					));
				}
			});
		})->export('xls');
	}
	public function pdf(){
    DBHelper::configureConnection(Auth::user()->db_alias);
		$data['mdepartement'] = MDepartement::on(Auth::user()->db_name)->where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mdepartementpdf',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master Departement.pdf');
	}
}
