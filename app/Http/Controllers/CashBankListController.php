<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;
use Excel;
use App\MCOA;
use App\MConfig;
use App\Helper\DBHelper;
use Auth;

class CashBankListController extends Controller
{

    private $data;

    public function index(){
        if(Auth::user()->has_role('R_cashbank')){
            $data['section'] = "Daftar Kas / Bank";
            $data['active'] = "cashbank";
            return view('admin.viewcashbanklist',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function excel(){
      $this->kas = MCOA::on(Auth::user()->db_name)->where('mcoaparentcode','1101.00')->get();
      $this->count = 0;
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      return Excel::create('Master Kas',function($excel){
        $excel->sheet('Master Kas',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->kas as $kas){
            $this->count++;
            $sheet->row($this->count,array(
              $kas->mcoacode,$kas->mcoaname,number_format($kas->saldo,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
      })->export('xls');

    }

    public function csv(){
      $this->kas = MCOA::on(Auth::user()->db_name)->where('mcoaparentcode','1101.00')->get();
      $this->count = 0;
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      return Excel::create('Master Kas',function($excel){
        $excel->sheet('Master Kas',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->kas as $kas){
            $this->count++;
            $sheet->row($this->count,array(
              $kas->mcoacode,$kas->mcoaname,number_format($kas->saldo,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
      })->export('csv');
    }

    public function pdf(){
      $data['kas'] = MCOA::on(Auth::user()->db_name)->where('mcoaparentcode','1101.00')->get();
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $data['decimals'] = $config->msysgenrounddec;
      $data['dec_point'] = $config->msysnumseparator;
      if($data['dec_point'] == ","){
        $data['thousands_sep'] = ".";
      } else {
        $data['thousands_sep'] = ",";
      }
      $pdf = PDF::loadview('admin/export/masterkas',$data);
      return $pdf->download('Master Kas.pdf');
    }

    public function excel_bank(){
      $this->kas = MCOA::on(Auth::user()->db_name)->where('mcoaparentcode','1102.00')->get();
      $this->count = 0;
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      return Excel::create('Master Bank',function($excel){
        $excel->sheet('Master Akun',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->kas as $kas){
            $this->count++;
            $sheet->row($this->count,array(
              $kas->mcoacode,$kas->mcoaname,number_format($kas->saldo,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
      })->export('xls');

    }

    public function csv_bank(){
      $this->kas = MCOA::on(Auth::user()->db_name)->where('mcoaparentcode','1102.00')->get();
      $this->count = 0;
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      return Excel::create('Master Bank',function($excel){
        $excel->sheet('Master Bank',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->kas as $kas){
            $this->count++;
            $sheet->row($this->count,array(
              $kas->mcoacode,$kas->mcoaname,number_format($kas->saldo,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
          }
        });
      })->export('csv');
    }

    public function pdf_bank(){
      $data['kas'] = MCOA::on(Auth::user()->db_name)->where('mcoaparentcode','1102.00')->get();
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $data['decimals'] = $config->msysgenrounddec;
      $data['dec_point'] = $config->msysnumseparator;
      if($data['dec_point'] == ","){
        $data['thousands_sep'] = ".";
      } else {
        $data['thousands_sep'] = ",";
      }
      $pdf = PDF::loadview('admin/export/masterkas',$data);
      return $pdf->stream('Master Bank.pdf');
    }
}
