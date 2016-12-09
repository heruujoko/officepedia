<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MGoodstype;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;

class MGoodstypeController extends Controller
{
  public function index(){
    $data['section'] = 'Master Tipe Barang';
    $data['active'] = 'mgoodstype';
    $data['mgoodstype'] = MGoodstype::on(Auth::user()->db_name)->get();
    return view('admin/viewmgoodstype',$data);
  }
  private $count =0;

  public function csv(){
    $this->brand = MGoodstype::on(Auth::user()->db_name)->get();
    return Excel::create('Master Tipe Barang',function($excel){
      $excel->sheet('Master Merek Barang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Tipe Barang','Keterangan'
        ));
        foreach($this->brand as $brand){
          $this->count++;
          $sheet->row($this->count,array(
            $brand->mgoodstypename,$brand->mgoodstyperemark
          ));
        }
      });
    })->export('csv');
}
public function excel(){
    $this->brand = MGoodstype::on(Auth::user()->db_name)->get();
    return Excel::create('Master Tipe Barang',function($excel){
      $excel->sheet('Master Merek Barang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Tipe Barang','Keterangan'
        ));
        foreach($this->brand as $brand){
          $this->count++;
          $sheet->row($this->count,array(
            $brand->mgoodsbrandname,$brand->mgoodstyperemark
          ));
        }
      });
    })->export('xls');
  }

  public function pdf(){
    $data['brand'] = MGoodstype::on(Auth::user()->db_name)->get();
    $pdf = PDF::loadview('admin/export/mgoodstype',$data);
    return $pdf->download('Master Tipe Barang.pdf');
  }


}
