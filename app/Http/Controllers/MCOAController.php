<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCOAParent;
use App\MCOAGrandParent;
use PDF;
use Excel;

class MCOAController extends Controller
{

    private $gparents;
    private $count;

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
      $pdf = PDF::loadview('admin/export/mcoapdf',$data);
      return $pdf->download('master akun.pdf');
    }

    public function excel(){
      $this->gparents = MCOAGrandParent::all();
      $this->count = 0;
      return Excel::create('Master Akun',function($excel){
        $excel->sheet('Master Akun',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Grand Parent Code','Grand Parent Name','Parent Code','Parent Name','MCOA Code','MCOA Name'
          ));
          foreach($this->gparents as $gp){
            $this->count++;
            $sheet->row($this->count,array(
              $gp->mcoagrandparentcode,$gp->mcoagrandparentname
            ));
            foreach($gp->childs() as $parent){
              $this->count++;
              $sheet->row($this->count,array(
                '','',$parent->mcoaparentcode,$parent->mcoaparentname
              ));
              foreach($parent->childs() as $mcoa){
                $this->count++;
                $sheet->row($this->count,array(
                  '','','','',$mcoa->mcoacode,$mcoa->mcoaname
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
      return Excel::create('Master Akun',function($excel){
        $excel->sheet('Master Akun',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Grand Parent Code','Grand Parent Name','Parent Code','Parent Name','MCOA Code','MCOA Name'
          ));
          foreach($this->gparents as $gp){
            $this->count++;
            $sheet->row($this->count,array(
              $gp->mcoagrandparentcode,$gp->mcoagrandparentname
            ));
            foreach($gp->childs() as $parent){
              $this->count++;
              $sheet->row($this->count,array(
                '','',$parent->mcoaparentcode,$parent->mcoaparentname
              ));
              foreach($parent->childs() as $mcoa){
                $this->count++;
                $sheet->row($this->count,array(
                  '','','','',$mcoa->mcoacode,$mcoa->mcoaname
                ));
              }
            }
          }
        });
      })->export('csv');
    }
}
