<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\MConfig;

use App\MHPurchasequotation;

use App\MDPurchasequotation;

use App\MSupplier;

Use Auth;

use Carbon\Carbon;

use PDF;
use Excel;
class PurchasequotationController extends Controller
{
    public function index(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'purchasequotation';
        $data['section'] = 'Transaksi Pembelian';
        return view('admin.purchasequotation',$data);
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
        $data['purchases'] = MHPurchasequotation::on(Auth::user()->db_name)->get();
        $pdf = PDF::loadview('admin/export/quotationpdf',$data);
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
      $this->purchases = MHPurchasequotation::on(Auth::user()->db_name)->where('void',0)->get();
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
              $p->mhpurchasequotationno,$p->mhpurchasequotationsuppliername,$p->mhpurchasequotationdate,$p->mhpurchasequotationduedate,number_format($p->mhpurchasequotationsubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhpurchasequotationtaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
              number_format($p->mhpurchasequotationdiscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhpurchasequotationgrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
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
      $this->purchases = MHPurchasequotation::on(Auth::user()->db_name)->where('void',0)->get();
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
               $p->mhpurchasequotationno,$p->mhpurchasequotationsuppliername,$p->mhpurchasequotationdate,$p->mhpurchasequotationduedate,number_format($p->mhpurchasequotationsubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhpurchasequotationtaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
              number_format($p->mhpurchasequotationdiscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhpurchasequotationgrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
    })->export('csv');
    }

    public function print2($mhpurchasequotationno){
      $data['carbon'] = carbon::now();
    	$data['config'] = MConfig::on(Auth::user()->db_name)->first();
    	$data['quotation'] = MHPurchasequotation::on(Auth::user()->db_name)->where('void',0)->where('mhpurchasequotationno',$mhpurchasequotationno)->get();
      $data['mdquotation'] = MDPurchasequotation::on(Auth::user()->db_name)->where('mhpurchaquotationseno',$mhpurchasequotationno)->get();
      $data['supplier'] = MSupplier::on(Auth::user()->db_name)->first();
    $data['subtotal'] = 0;
    $data['discount'] = 0;
    $data['totalitem'] = 0;
    foreach($data['mdquotation'] as $a){
      $data['subtotal']+=$a->mdpurchasequotationbuyprice * $a->mdpurchasequotationgoodsqty - $a->mdpurchasequotationgoodsdiscount;
      $data['discount']+=$a->mdpurchasequotationgoodsdiscount;
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

		$pdf = PDF::loadview('admin/export/purchasequotation',$data);
		return $pdf->setPaper('a4', 'potrait')->stream('Master purchase Quotation.pdf');
    }
}
