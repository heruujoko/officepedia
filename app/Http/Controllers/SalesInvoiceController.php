<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MCUSTOMER;
use App\MGoods;
use App\MUnit;
use App\MTax;
use App\MWarehouse;
use Auth;
use App\Http\Requests;
use App\MHInvoice;
use App\Helper\DBHelper;
use App\Helper\UnitHelper;
use Excel;
use PDF;
use App\MConfig;

class SalesInvoiceController extends Controller
{
    public function index(){

        if(Auth::user()->has_role('R_sales')){
            $data['active'] = 'salesinvoice';
            $data['section'] = 'Transaksi Faktur Penjualan';
            // $data['customers'] = MCUSTOMER::on(Auth::user()->db_name)->get();
            // $data['goods'] = MGoods::on(Auth::user()->db_name)->get();
            // $data['units'] = MUnit::on(Auth::user()->db_name)->get();
            // $data['taxes'] = MTax::on(Auth::user()->db_name)->get();
            // $data['whouses'] = MWarehouse::on(Auth::user()->db_name)->get();
            return view('admin.salesinvoicevue',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function csv(){
      DBHelper::configureConnection(Auth::user()->db_alias);
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      $this->mhinvoice = MHInvoice::on(Auth::user()->db_name)->where('void',0)->get();
      $this->count = 0;
      return Excel::create('Master Transaksi Penjualan',function($excel){
        $excel->sheet('Master Transaksi Penjualan',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Nomor Invoice','Customer','Tanggal','Jatuh Tempo','Subtotal','Pajak','Diskon','Total'
          ));
          foreach($this->mhinvoice as $invoice){
            $this->count++;
            $sheet->row($this->count,array(
               $invoice->mhinvoiceno,$invoice->customers()->mcustomername,$invoice->mhinvoicedate,$invoice->mhinvoiceduedate,number_format($invoice->mhinvoicesubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($invoice->mhinvoicetaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
               number_format($invoice->mhinvoicediscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($invoice->mhinvoicegrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
      })->export('csv');
    }

    public function excel(){
      DBHelper::configureConnection(Auth::user()->db_alias);
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      $this->mhinvoice = MHInvoice::on(Auth::user()->db_name)->where('void',0)->get();
      $this->count = 0;
      return Excel::create('Master Transaksi Penjualan',function($excel){
        $excel->sheet('Master Transaksi Penjualan',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Nomor Invoice','Customer','Tanggal','Jatuh Tempo','Subtotal','Pajak','Diskon','Total'
          ));
          foreach($this->mhinvoice as $invoice){
            $this->count++;
            $sheet->row($this->count,array(
              $invoice->mhinvoiceno,$invoice->customers()->mcustomername,$invoice->mhinvoicedate,$invoice->mhinvoiceduedate,number_format($invoice->mhinvoicesubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($invoice->mhinvoicetaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
              number_format($invoice->mhinvoicediscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),number_format($invoice->mhinvoicegrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
      })->export('xls');
    }

    public function pdf(){
      DBHelper::configureConnection(Auth::user()->db_alias);
      $data['invoices'] = MHInvoice::on(Auth::user()->db_name)->get();
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $data['decimals'] = $config->msysgenrounddec;
      $data['dec_point'] = $config->msysnumseparator;
      if($data['dec_point'] == ","){
        $data['thousands_sep'] = ".";
      } else {
        $data['thousands_sep'] = ",";
      }
      $pdf = PDF::loadview('admin/export/mhinvoice',$data);
      return $pdf->download('master transaksi penjualan.pdf');
      // return view('admin/export/mcoapdf',$data);
    }

    public function lptPrint($invoiceno){
        $data['invoice'] = MHINvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$invoiceno)->first();
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['config'] = $config;
        $inv_details = $data['invoice']->details();

        $data['sum_subtotal'] = 0;
        $data['sum_tax'] = 0;
        $data['sum_disc'] = 0;

        foreach ($inv_details as $d) {
            $goods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mdinvoicegoodsid)->first();
            $d['qty_label'] = UnitHelper::label($goods,$d->mdinvoicegoodsqty);
            $data['sum_subtotal'] += $d->mdinvoicegoodsgrossamount;
            $data['sum_tax'] += $d->mdinvoicegoodstax;
            $data['sum_disc'] += $d->mdinvoicegoodsdiscount;
        }
        $data['details'] = $inv_details;
        return view('admin.export.invoicelpt',$data);
    }
}
