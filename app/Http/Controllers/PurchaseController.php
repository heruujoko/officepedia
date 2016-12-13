<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MConfig;
use Auth;
use App\Http\Requests;
use App\MHPurchase;
use PDF;
use Excel;

class PurchaseController extends Controller
{
    public function index(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'purchaseinvoice';
        $data['section'] = 'Transaksi Pembelian';
        return view('admin.purchaseinvoice',$data);
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
        $data['purchases'] = MHPurchase::on(Auth::user()->db_name)->get();
        $pdf = PDF::loadview('admin/export/mhpurchase',$data);
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
      $this->purchases = MHPurchase::on(Auth::user()->db_name)->where('void',0)->get();
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
              $p->mhpurchaseno,$p->mhpurchasesuppliername,$p->mhpurchasedate,$p->mhpurchaseduedate,number_format($p->mhpurchasesubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhpurchasetaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
              number_format($p->mhpurchasediscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhpurchasegrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
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
      $this->purchases = MHPurchase::on(Auth::user()->db_name)->where('void',0)->get();
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
              $p->mhpurchaseno,$p->mhpurchasesuppliername,$p->mhpurchasedate,$p->mhpurchaseduedate,number_format($p->mhpurchasesubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhpurchasetaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
              number_format($p->mhpurchasediscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($p->mhpurchasegrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
    })->export('csv');
    }
}
