<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Excel;
use PDF;
use App\MTax;

class MTaxController extends Controller
{

  private $mtax;
  private $count;

  public function index(){
    $data['active'] = 'mtax';
    $data['section'] = 'Master Pajak';
    return view('admin/viewmtax',$data);
  }

  public function csv(){
		$this->mtax = MTax::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Pajak',function($excel){
			$excel->sheet('Master Pajak',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Tipe','Deskripsi','Persentase'
				));
				foreach($this->mtax as $tax){
					$this->count++;
					$sheet->row($this->count,array(
						$tax->mtaxtype,$tax->mtaxtdesc,$tax->mtaxtpercentage.'%'
					));
				}
			});
		})->export('csv');
	}

  public function excel(){
		$this->mtax = MTax::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Pajak',function($excel){
			$excel->sheet('Master Pajak',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Tipe','Deskripsi','Persentase'
				));
				foreach($this->mtax as $tax){
					$this->count++;
					$sheet->row($this->count,array(
						$tax->mtaxtype,$tax->mtaxtdesc,$tax->mtaxtpercentage.'%'
					));
				}
			});
		})->export('xlsx');
	}

  public function pdf(){
		$data['mtax'] = MTax::where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mtax',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Master Pajak.pdf');
	}

}
