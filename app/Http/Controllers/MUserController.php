<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MUser;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;
use App\Role;
use App\MBRANCH;

class MUserController extends Controller
{
    public function index(){
      DBHelper::configureConnection(Auth::user()->db_alias);
    	$data['active'] = 'muser';
		$data['section'] = 'Master User';
    	$data['activetab'] = 1;
		$data['MCategorygoods'] = MUser::on(Auth::user()->db_name)->get();
		$data['id'] = null;
        $data['roles'] = Role::on(Auth::user()->db_name)->get();
        $data['branches'] = MBRANCH::on(Auth::user()->db_name)->get();
	    return view('admin/viewmuser',$data);
	  }

	public function csv(){
    DBHelper::configureConnection(Auth::user()->db_alias);
		$this->mcategory = MUser::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master User',function($excel){
			$excel->sheet('Master User',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Nama User','Password'
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
		$this->mcategory = MUser::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master User',function($excel){
			$excel->sheet('Master User',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Nama User','Password'
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
    DBHelper::configureConnection(Auth::user()->db_alias);
		$data['brand'] = MUser::on(Auth::user()->db_name)->where('void',0)->get();
		$pdf = PDF::loadview('admin/export/muserpdf',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master User.pdf');
	}
}
