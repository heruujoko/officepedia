<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MEmployeeLevel;
use App\Http\Requests;
use App\MCOA;

use Excel;
use PDF;
use App\MEmployee;

class MEmployeeController extends Controller
{
    public function index(){
      $data['active'] = 'memployee';
      $data['section'] = 'Master Karyawan';
      $data['level'] = MEmployeeLevel::all();
      $data['mcoa'] = MCOA::all();
      return view('admin.viewmemployee',$data);
    }

    public function csv(){
  		$this->memployee = MEmployee::where('void',0)->get();
  		$this->count = 0;
  		return Excel::create('Master Karyawan',function($excel){
  			$excel->sheet('Master Karyawan',function($sheet){
  				$this->count++;
  				$sheet->row($this->count,array(
  					'ID Karyawan','Sapaan','Nama Karyawan','Posisi','Level','HP','Telfon','Pin BBM','No KTP','Kota','Kode Pos','Provinsi','Negara','Nama Kontak','Posisi','Email Kontak','Handphone','Limit','Akun','TOP','Maksimum Nota','Default'
  				));
  				foreach($this->memployee as $empl){
  					$this->count++;
  					$sheet->row($this->count,array(
              $empl->memployeeid,
              $empl->memployeetitle,
              $empl->memployeename,
              $empl->memployeeposition,
              $empl->memployeelevel,
              $empl->memployeephone,
              $empl->memployeehomephone,
              $empl->memployeebbmpin,
              $empl->memployeeidcard,
              $empl->memployeecity,
              $empl->memployeezipcode,
              $empl->memployeeprovince,
              $empl->memployeecountry,
              $empl->memployeecontactname,
              $empl->memployeecontactposition,
              $empl->memployeecontactemail,
              $empl->memployeecontactemailphone,
              $empl->memployeearlimit,
              $empl->akun->mcoaname,
              $empl->memployeetop,
              $empl->memployeearmax,
              $empl->memployeedefaultar,
  					));
  				}
  			});
  		})->export('csv');
  	}

    public function excel(){
  		$this->memployee = MEmployee::where('void',0)->get();
  		$this->count = 0;
  		return Excel::create('Master Karyawan',function($excel){
  			$excel->sheet('Master Karyawan',function($sheet){
  				$this->count++;
  				$sheet->row($this->count,array(
  					'ID Karyawan','Sapaan','Nama Karyawan','Posisi','Level','HP','Telfon','Pin BBM','No KTP','Kota','Kode Pos','Provinsi','Negara','Nama Kontak','Posisi','Email Kontak','Handphone','Limit','Akun','TOP','Maksimum Nota','Default'
  				));
  				foreach($this->memployee as $empl){
  					$this->count++;
  					$sheet->row($this->count,array(
              $empl->memployeeid,
              $empl->memployeetitle,
              $empl->memployeename,
              $empl->memployeeposition,
              $empl->memployeelevel,
              $empl->memployeephone,
              $empl->memployeehomephone,
              $empl->memployeebbmpin,
              $empl->memployeeidcard,
              $empl->memployeecity,
              $empl->memployeezipcode,
              $empl->memployeeprovince,
              $empl->memployeecountry,
              $empl->memployeecontactname,
              $empl->memployeecontactposition,
              $empl->memployeecontactemail,
              $empl->memployeecontactemailphone,
              $empl->memployeearlimit,
              $empl->akun->mcoaname,
              $empl->memployeetop,
              $empl->memployeearmax,
              $empl->memployeedefaultar,
  					));
  				}
  			});
  		})->export('xlsx');
  	}

    public function pdf(){
  		$data['memployee'] = MEmployee::where('void',0)->get();
  		$pdf = PDF::loadview('admin/export/memployeepdf',$data);
  		return $pdf->setPaper('a3', 'landscape')->download('Master Karyawan.pdf');
  	}
}
