<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\MConfig;

use App\MHSalesquotation;

use App\MDSalesquotation;

use App\MSupplier;

Use Auth;

use Carbon\Carbon;

use PDF;
use Excel;
class SalesquotationController extends Controller
{
    public function index(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'salesquotation';
        $data['section'] = 'Transaksi Pembelian';
        return view('admin.salesquotation',$data);
    }
    public function pdf(){
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['purchases'] = MHSalesquotation::on(Auth::user()->db_name)->get();
        $pdf = PDF::loadview('admin/export/salesquotationpdf',$data);
        return $pdf->setPaper('a4', 'potrait')->download('Master Transaksi Pembelian.pdf');
    }

      public function excel(){
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      $this->purchases = MHSalesquotation::on(Auth::user()->db_name)->where('void',0)->get();
      $this->count = 0;
      return Excel::create('Master Transaksi Pembelian',function($excel){
        $excel->sheet('Master Transaksi Pembelian',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Nomor Invoice','Supplier','Tanggal','Jatuh Tempo','Subtotal','Pajak','Diskon','Total'
          ));
          foreach($this->purchases as $p){
            $this->count++;
            $sheet->row($this->count,array(
              $p->mhsalesquotationno,$p->mhsalesquotationsuppliername,$p->mhsalesquotationdate,$p->mhsalesquotationduedate,number_format($p->mhsalesquotationsubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhsalesquotationtaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
              number_format($p->mhsalesquotationdiscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhsalesquotationgrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
      })->export('xls');
    }

    public function csv(){
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      $this->purchases = MHSalesquotation::on(Auth::user()->db_name)->where('void',0)->get();
      $this->count = 0;
      return Excel::create('Master Transaksi Pembelian',function($excel){
        $excel->sheet('Master Transaksi Pembelian',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Nomor Invoice','Supplier','Tanggal','Jatuh Tempo','Subtotal','Pajak','Diskon','Total'
          ));
          foreach($this->purchases as $p){
            $this->count++;
            $sheet->row($this->count,array(
               $p->mhsalesquotationno,$p->mhsalesquotationsuppliername,$p->mhsalesquotationdate,$p->mhsalesquotationduedate,number_format($p->mhsalesquotationsubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhsalesquotationtaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
              number_format($p->mhsalesquotationdiscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhsalesquotationgrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
    })->export('csv');
    }

    public function print2($mhsalesquotationno){
      $data['carbon'] = carbon::now();
      $data['config'] = MConfig::on(Auth::user()->db_name)->first();
      $data['quotation'] = MHSalesquotation::on(Auth::user()->db_name)->where('void',0)->where('mhsalesquotationno',$mhsalesquotationno)->get();
      $data['mdquotation'] = MDSalesquotation::on(Auth::user()->db_name)->where('mhsalesotationseno',$mhsalesquotationno)->get();
      $data['supplier'] = MSupplier::on(Auth::user()->db_name)->first();
    $data['subtotal'] = 0;
    $data['discount'] = 0;
    $data['totalitem'] = 0;
    foreach($data['mdquotation'] as $a){
      $data['subtotal']+=$a->mdsalesquotationbuyprice * $a->mdsalesgoodsqty - $a->mdsalesgoodsdiscount;
      $data['discount']+=$a->mdsalesgoodsdiscount;
      $data['totalitem']+=1;
    }
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
		$pdf = PDF::loadview('admin/export/salesquotation',$data);
		return $pdf->setPaper('a4', 'potrait')->stream('Master Sales Quotation.pdf');
    }
}
