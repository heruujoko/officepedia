<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MGoodssubtype;
use App\MGoodstype;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;

class MGoodssubtypeController extends Controller
{
    public function index(){
    $data['section'] = 'Master Sub Tipe Barang';
    $data['active'] = 'mgoodssubtype';
    $data['mgoodstype'] = MGoodstype::on(Auth::user()->db_name)->get();
    $data['mgoodssubtype'] = MGoodssubtype::on(Auth::user()->db_name)->get();
    return view('admin/viewmgoodssubtype',$data);
  }
   private $count =0;

  public function csv(){
    $this->brand = MGoodssubtype::on(Auth::user()->db_name)->get();
    return Excel::create('Master Sub Tipe Barang',function($excel){
      $excel->sheet('Master Sub Tipe Barang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Sub Tipe Barang','Tipe Barang','Keterangan'
        ));
        foreach($this->brand as $brand){
          $this->count++;
          $sheet->row($this->count,array(
            $brand->mgoodssubtypename,$brand->mgoodssubtypeparent,$brand->mgoodssubtyperemark
          ));
        }
      });
    })->export('csv');
}
public function excel(){
    $this->brand = MGoodssubtype::on(Auth::user()->db_name)->get();
    return Excel::create('Master Sub Tipe Barang',function($excel){
      $excel->sheet('Master Sub Tipe Barang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Sub Tipe Barang','Tipe Barang','Keterangan'
        ));
        foreach($this->brand as $brand){
          $this->count++;
          $sheet->row($this->count,array(
            $brand->mgoodssubtypename,$brand->mgoodssubtypeparent,$brand->mgoodssubtyperemark
          ));
        }
      });
    })->export('xls');
  }

  public function pdf(){
    $data['brand'] = MGoodssubtype::on(Auth::user()->db_name)->get();
    $pdf = PDF::loadview('admin/export/mgoodssubtypepdf',$data);
    return $pdf->download('Master Sub Tipe Barang.pdf');
  }


}
