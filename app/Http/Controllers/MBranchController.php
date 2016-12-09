<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MBRANCH;
use Excel;
use PDF;

class MBranchController extends Controller
{
  private $count =0;

  public function csv(){
    $this->branches = MBRANCH::all();
    return Excel::create('Master Cabang',function($excel){
      $excel->sheet('Master Cabang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Kode Cabang','Nama Cabang','Alamat','Telpon','Kota','Orang Yang Bertanggung Jawab','Keterangan'
        ));
        foreach($this->branches as $branch){
          $this->count++;
          $sheet->row($this->count,array(
            $branch->mbranchcode,$branch->mbranchname,$branch->address,$branch->phone,$branch->city,$branch->person_in_charge,$branch->information
          ));
        }
      });
    })->export('csv');
  }

  public function excel(){
    $this->branches = MBRANCH::all();
    return Excel::create('Master Cabang',function($excel){
      $excel->sheet('Master Cabang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Kode Cabang','Nama Cabang','Alamat','Telpon','Kota','Orang Yang Bertanggung Jawab','Keterangan'
        ));
        foreach($this->branches as $branch){
          $this->count++;
          $sheet->row($this->count,array(
            $branch->mbranchcode,$branch->mbranchname,$branch->address,$branch->phone,$branch->city,$branch->person_in_charge,$branch->information
          ));
        }
      });
    })->export('xls');
  }

  public function pdf(){
    $data['branches'] = MBRANCH::all();
    $pdf = PDF::loadview('admin/export/mbranchpdf',$data);
    return $pdf->download('Master Cabang.pdf');
  }
}
