<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;
use App\MHPayAr;
use PDF;
use Excel;

class PayArController extends Controller
{
    public function payar(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'payar';
        $data['section'] = 'Pembayaran Piutang Dagang';
        return view('admin.payar',$data);
    }

    public function payar_pdf(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['pays'] = MHPayAR::on(Auth::user()->db_name)->get();
        foreach($data['pays'] as $pap){
            $pap['outstanding'] = ($pap->mhpayapsubtotal - $pap->mhpayappayamount);
        }
        $pdf = PDF::loadview('admin/export/payar',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Pembayaran Piutang Dagang.pdf');
    }

    public function payar_excel(){
        $data['pays'] = MHPayAR::on(Auth::user()->db_name)->get();
        foreach($data['pays'] as $pap){
            $pap['outstanding'] = ($pap->mhpayarsubtotal - $pap->mhpayarpayamount);
        }
        $this->pays = $data['pays'];
        $this->count =0;
        return Excel::create('Pembayaran Piutang Dagang',function($excel){
			$excel->sheet('Pembayaran Piutang Dagang',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Nomor Invoice','Nama Customer','Tanggal','Pembayaran','Outstanding','Remarks'
				));
				foreach($this->pays as $p){
					$this->count++;
					$sheet->row($this->count,array(
						$p->mhpayarno,$p->mhpayarcustomername,$p->mhpayardate,$p->mhpayarpayamount,$p['outstanding'],$p->mhpayarremarks
					));
				}
			});
		})->export('xls');
    }

    public function payar_csv(){
        $data['pays'] = MHPayAR::on(Auth::user()->db_name)->get();
        foreach($data['pays'] as $pap){
            $pap['outstanding'] = ($pap->mhpayarsubtotal - $pap->mhpayarpayamount);
        }
        $this->pays = $data['pays'];
        $this->count =0;
        return Excel::create('Pembayaran Piutang Dagang',function($excel){
			$excel->sheet('Pembayaran Piutang Dagang',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Nomor Invoice','Nama Customer','Tanggal','Pembayaran','Outstanding','Remarks'
				));
				foreach($this->pays as $p){
					$this->count++;
					$sheet->row($this->count,array(
						$p->mhpayarno,$p->mhpayarcustomername,$p->mhpayardate,$p->mhpayarpayamount,$p['outstanding'],$p->mhpayarremarks
					));
				}
			});
		})->export('csv');
    }
}
