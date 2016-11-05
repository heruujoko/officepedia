<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\MWarehouse;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;

class MWarehouseController extends Controller
{
    public function index(){
    $data['active'] = 'mwarehouse';
		$data['section'] = 'Gudang';
    $data['activetab'] = 1;
		$data['mwarehouse'] = MWarehouse::on(Auth::user()->db_name)->get();
		$data['id'] = null;
	  	return view('admin/viewmwarehouse',$data);
    }

  public function csv(){
    DBHelper::configureConnection(Auth::user()->db_alias);
    $this->mwarehouse = MWarehouse::on(Auth::user()->db_name)->where('void',0)->get();
    $this->count = 0;
    return Excel::create('Master Warehouse',function($excel){
      $excel->sheet('Master Master Warehouse',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
          'Nama Gudang','Alamat','Kota','Kode Pos','Provinsi','Negara','Keterangan'
        ));
        foreach($this->mwarehouse as $brand){
          $this->count++;
          $sheet->row($this->count,array(
             $brand->mwarehousename,$brand->mwarehouseaddress,$brand->mwarehousecity,$brand->mwarehousezipcode,$brand->mwarehouseprovince,$brand->mwarehousecountry,$brand->mwarehouseremark
          ));
        }
      });
    })->export('csv');
  }
  public function excel(){
    DBHelper::configureConnection(Auth::user()->db_alias);
    $this->mwarehouse = MWarehouse::on(Auth::user()->db_name)->where('void',0)->get();
    $this->count = 0;
    return Excel::create('Master Warehouse',function($excel){
      $excel->sheet('Master Master Warehouse',function($sheet){
        $this->count++;
        $sheet->row($this->count,array(
        'Nama Gudang','Alamat','Kota','Kode Pos','Provinsi','Negara','Keterangan'
        ));
        foreach($this->mwarehouse as $brand){
          $this->count++;
          $sheet->row($this->count,array(
             $brand->mwarehousename,$brand->mwarehouseaddress,$brand->mwarehousecity,$brand->mwarehousezipcode,$brand->mwarehouseprovince,$brand->mwarehousecountry,$brand->mwarehouseremark
          ));
        }
      });
    })->export('xlsx');
  }
  public function pdf(){
    DBHelper::configureConnection(Auth::user()->db_alias);
    $data['brand'] = MWarehouse::on(Auth::user()->db_name)->where('void',0)->get();
    $pdf = PDF::loadview('admin/export/mwarehousepdf',$data);
    return $pdf->setPaper('a3', 'landscape')->download('Master Warehouse.pdf');
  }



}
