<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCOAParent;
use App\MCOAGrandParent;
use PDF;
use Excel;
use App\MConfig;

class MCOAController extends Controller
{

    private $gparents;
    private $count;
    private $data;

    public function index(){
      $data['active'] = 'mcoa';
      $data['section'] = 'MCOA';
      $data['parents'] = MCOAParent::all();
      $data['gparents'] = MCOAGrandParent::all();

      return view('admin/viewmcoa',$data);
    }

    public function xprint(){
      $data['gparents'] = MCOAGrandParent::all();
      return view('admin/export/mcoaprint',$data);
    }

    public function pdf(){
      $data['gparents'] = MCOAGrandParent::all();
      $config = MConfig::find(1);
      $data['decimals'] = $config->msysgenrounddec;
      $data['dec_point'] = $config->msysnumseparator;
      if($data['dec_point'] == ","){
        $data['thousands_sep'] = ".";
      } else {
        $data['thousands_sep'] = ",";
      }
      $pdf = PDF::loadview('admin/export/mcoapdf',$data);
      return $pdf->download('master akun.pdf');
      // return view('admin/export/mcoapdf',$data);
    }

    public function excel(){
      $this->gparents = MCOAGrandParent::all();
      $this->count = 0;
      $config = MConfig::find(1);
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      return Excel::create('Master Akun',function($excel){
        $excel->sheet('Master Akun',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Grand Parent Code','Grand Parent Name','Parent Code','Parent Name','MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->gparents as $gp){
            $this->count++;
            $sheet->row($this->count,array(
              $gp->mcoagrandparentcode,$gp->mcoagrandparentname,'','','','',number_format($gp->saldo,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
            ));
            foreach($gp->childs() as $parent){
              $this->count++;
              $sheet->row($this->count,array(
                '','',$parent->mcoaparentcode,$parent->mcoaparentname,'','',number_format($parent->saldo,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
              ));
              foreach($parent->childs() as $mcoa){
                $this->count++;
                $sheet->row($this->count,array(
                  '','','','',$mcoa->mcoacode,$mcoa->mcoaname,number_format($mcoa->saldo,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
                ));
              }
            }
          }
        });
      })->export('xlsx');

    }

    public function csv(){
      $this->gparents = MCOAGrandParent::all();
      $this->count = 0;
      $config = MConfig::find(1);
      $this->data['decimals'] = $config->msysgenrounddec;
      $this->data['dec_point'] = $config->msysnumseparator;
      if($this->data['dec_point'] == ","){
        $this->data['thousands_sep'] = ".";
      } else {
        $this->data['thousands_sep'] = ",";
      }
      return Excel::create('Master Akun',function($excel){
        $excel->sheet('Master Akun',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Grand Parent Code','Grand Parent Name','Parent Code','Parent Name','MCOA Code','MCOA Name','Saldo'
          ));
          foreach($this->gparents as $gp){

            foreach($gp->childs() as $parent){

              foreach($parent->childs() as $mcoa){
                $this->count++;
                $sheet->row($this->count,array(
                  $gp->mcoagrandparentcode,$gp->mcoagrandparentname,$parent->mcoaparentcode,$parent->mcoaparentname,$mcoa->mcoacode,$mcoa->mcoaname,number_format($gp->mcoa,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep'])
                ));
              }
            }
          }
        });
      })->export('csv');
    }
}
