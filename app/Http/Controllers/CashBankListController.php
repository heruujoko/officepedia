<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;
use Excel;
use App\MCOA;

class CashBankListController extends Controller
{
    public function index(){
      $data['section'] = "Daftar Kas / Bank";
      $data['active'] = "cashbank";
      return view('admin.viewcashbanklist',$data);
    }

    public function excel(){
      $this->kas = MCOA::where('mcoaparentcode','1101.00')->get();
      $this->count = 0;
      return Excel::create('Master Kas',function($excel){
        $excel->sheet('Master Kas',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->kas as $kas){
            $this->count++;
            $sheet->row($this->count,array(
              $kas->mcoacode,$kas->mcoaname,$kas->saldo
            ));
          }
        });
      })->export('xlsx');

    }

    public function csv(){
      $this->kas = MCOA::where('mcoaparentcode','1101.00')->get();
      $this->count = 0;
      return Excel::create('Master Kas',function($excel){
        $excel->sheet('Master Kas',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->kas as $kas){
            $this->count++;
            $sheet->row($this->count,array(
              $kas->mcoacode,$kas->mcoaname,$kas->saldo
            ));
          }
        });
      })->export('csv');
    }

    public function pdf(){
      $data['kas'] = MCOA::where('mcoaparentcode','1101.00')->get();
      $pdf = PDF::loadview('admin/export/masterkas',$data);
      return $pdf->download('Master Kas.pdf');
    }

    public function excel_bank(){
      $this->kas = MCOA::where('mcoaparentcode','1102.00')->get();
      $this->count = 0;
      return Excel::create('Master Bank',function($excel){
        $excel->sheet('Master Akun',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->kas as $kas){
            $this->count++;
            $sheet->row($this->count,array(
              $kas->mcoacode,$kas->mcoaname,$kas->saldo
            ));
          }
        });
      })->export('xlsx');

    }

    public function csv_bank(){
      $this->kas = MCOA::where('mcoaparentcode','1102.00')->get();
      $this->count = 0;
      return Excel::create('Master Bank',function($excel){
        $excel->sheet('Master Bank',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->kas as $kas){
            $this->count++;
            $sheet->row($this->count,array(
              $kas->mcoacode,$kas->mcoaname,$kas->saldo
            ));
          }
        });
      })->export('csv');
    }

    public function pdf_bank(){
      $data['kas'] = MCOA::where('mcoaparentcode','1102.00')->get();
      $pdf = PDF::loadview('admin/export/masterkas',$data);
      return $pdf->download('Master Bank.pdf');
    }
}
