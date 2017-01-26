<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MEmployeeLevel;
use App\Http\Requests;
use App\MCOA;

use Excel;
use PDF;
use App\MEmployee;
use Auth;

class MEmployeeController extends Controller
{
    public function index(){

        if(Auth::user()->has_role('R_employee')){
            $data['active'] = 'memployee';
            $data['section'] = 'Master Karyawan';
            $data['level'] = MEmployeeLevel::on(Auth::user()->db_name)->get();
            $data['mcoa'] = MCOA::on(Auth::user()->db_name)->get();
            return view('admin.viewmemployee',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function csv(){
  		$this->memployee = MEmployee::on(Auth::user()->db_name)->where('void',0)->get();
  		$this->count = 0;
  		return Excel::create('Master Karyawan',function($excel){
  			$excel->sheet('Master Karyawan',function($sheet){
  				$this->count++;
  				$sheet->row($this->count,array(
  					'ID Karyawan','Sapaan','Nama Karyawan','Posisi','Level','HP','Telfon','Pin BBM','No KTP','Kota','Kode Pos','Provinsi','Negara','Informasi'
  				));
  				foreach($this->memployee as $empl){
  					$this->count++;
  					$sheet->row($this->count,array(
              $empl->memployeeid,
              $empl->memployeetitle,
              $empl->memployeename,
              $empl->memployeeposition,
              $empl->level()->level,
              $empl->memployeephone,
              $empl->memployeehomephone,
              $empl->memployeebbmpin,
              $empl->memployeeidcard,
              $empl->memployeecity,
              $empl->memployeezipcode,
              $empl->memployeeprovince,
              $empl->memployeecountry,
              $empl->memployeeinfo,
  					));
  				}
  			});
  		})->export('csv');
  	}

    public function excel(){
  		$this->memployee = MEmployee::on(Auth::user()->db_name)->where('void',0)->get();
  		$this->count = 0;
  		return Excel::create('Master Karyawan',function($excel){
  			$excel->sheet('Master Karyawan',function($sheet){
  				$this->count++;
  				$sheet->row($this->count,array(
  					'ID Karyawan','Sapaan','Nama Karyawan','Posisi','Level','HP','Telfon','Pin BBM','No KTP','Kota','Kode Pos','Provinsi','Negara','Informasi'
  				));
  				foreach($this->memployee as $empl){
  					$this->count++;
  					$sheet->row($this->count,array(
              $empl->memployeeid,
              $empl->memployeetitle,
              $empl->memployeename,
              $empl->memployeeposition,
              $empl->level()->level,
              $empl->memployeephone,
              $empl->memployeehomephone,
              $empl->memployeebbmpin,
              $empl->memployeeidcard,
              $empl->memployeecity,
              $empl->memployeezipcode,
              $empl->memployeeprovince,
              $empl->memployeecountry,
              $empl->memployeeinfo,
  					));
  				}
  			});
  		})->export('xls');
  	}

    public function pdf(){
  		$data['memployee'] = MEmployee::on(Auth::user()->db_name)->where('void',0)->get();
  		$pdf = PDF::loadview('admin/export/memployeepdf',$data);
  		return $pdf->setPaper('a4', 'potrait')->download('Master Karyawan.pdf');
  	}
}
