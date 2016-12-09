<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MGoodsbrand;
use Excel;
use PDF;

class MGoodsbrandController extends Controller
{
  public function index(){
    $data['section'] = 'Merek Barang';
    $data['active'] = 'mgoodsbrand';
    $data['mgoodsbrand'] = MGoodsbrand::all();
    return view('admin/viewmgoodsbrand',$data);
  }
   private $count =0;

  public function csv(){
    $this->brand = MGoodsbrand::all();
    return Excel::create('Master Merek Barang',function($excel){
      $excel->sheet('Master Merek Barang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Merek Barang','Keterangan'
        ));
        foreach($this->brand as $brand){
          $this->count++;
          $sheet->row($this->count,array(
            $brand->mgoodsbrandname,$brand->mgoodsbrandremark
          ));
        }
      });
    })->export('csv');
}
public function excel(){
    $this->brand = MGoodsbrand::all();
    return Excel::create('Master Merek Barang',function($excel){
      $excel->sheet('Master Merek Barang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Merek Barang','Keterangan'
        ));
        foreach($this->brand as $brand){
          $this->count++;
          $sheet->row($this->count,array(
            $brand->mgoodsbrandname,$brand->mgoodsbrandremark
          ));
        }
      });
    })->export('xls');
  }

  public function pdf(){
    $data['brand'] = MGoodsbrand::all();
    $pdf = PDF::loadview('admin/export/mgoodsbrandpdf',$data);
    return $pdf->download('Master Merek Barang.pdf');
  }


}