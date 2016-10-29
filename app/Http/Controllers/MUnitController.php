<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Munit;
use Excel;
use PDF;

class MUnitController extends Controller
{

  private $count;

  public function index(){
    $data['section'] = 'Master Satuan';
    $data['active'] = 'munit';
    return view('admin/viewmunits',$data);
  }
  public function csv(){
    $this->brand = MUnit::all();
    return Excel::create('Master Satuan Barang',function($excel){
      $excel->sheet('Master Satuan Barang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Satuan Barang','Keterangan'
        ));
        foreach($this->brand as $brand){
          $this->count++;
          $sheet->row($this->count,array(
            $brand->mgoodunitname,$brand->mgoodsunitremark
          ));
        }
      });
    })->export('csv');
  }
  public function excel(){
    $this->brand = MUnit::all();
    return Excel::create('Master Satuan Barang',function($excel){
      $excel->sheet('Master Satuan Barang',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Satuan Barang','Keterangan'
        ));
        foreach($this->brand as $brand){
          $this->count++;
          $sheet->row($this->count,array(
            $brand->mgoodsunitname,$brand->mgoodsunitremark
          ));
        }
      });
    })->export('xlsx');
  }

  public function pdf(){
    $data['satuans'] = MUnit::all();
    $pdf = PDF::loadview('admin/export/munits',$data);
    return $pdf->download('Master Satuan Barang.pdf');
  }
}
