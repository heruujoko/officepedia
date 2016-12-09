<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCOA;
use App\MPrefix;
use PDF;
use Excel;

class MPrefixController extends Controller
{
    private $count = 0;
    private $previxes = array();

    public function index(){
      $data['transactions'] = MCOA::all();
      $data['active'] = "mprefix";
      $data['section'] = "MPrefix";
      return view('admin/viewmprefix',$data);
    }

    public function csv(){
      $this->prefixes = MPrefix::all();
      return Excel::create('Master Prefix',function($excel){
        $excel->sheet('Master Prefix',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Prefix','Transaction','Remark','Last Count'
          ));
          foreach($this->prefixes as $px){
            $this->count++;
            $sheet->row($this->count,array(
              $px->mprefix,$px->mprefixtransaction,$px->mprefixremark,$px->last_count
            ));
          }
        });
      })->export('csv');
    }

    public function excel(){
      $this->prefixes = MPrefix::all();
      return Excel::create('Master Prefix',function($excel){
        $excel->sheet('Master Prefix',function($sheet){
          $this->count++;
          $sheet->row($this->count,array(
            'Prefix','Transaction','Remark','Last Count'
          ));
          foreach($this->prefixes as $px){
            $this->count++;
            $sheet->row($this->count,array(
              $px->mprefix,$px->mprefixtransaction,$px->mprefixremark,$px->last_count
            ));
          }
        });
      })->export('xls');
    }

    public function pdf(){
      $data['prefixes'] = MPrefix::all();
      $pdf = PDF::loadview('admin/export/mprefixpdf',$data);
      return $pdf->download('Master Prefix.pdf');
    }
}
