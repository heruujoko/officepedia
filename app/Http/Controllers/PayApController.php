<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;
use App\MHPayAp;
use PDF;
use Excel;

class PayApController extends Controller
{
    public function payap(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'payap';
        $data['section'] = 'Pembayaran Hutang Dagang';
        return view('admin.payap',$data);
    }

    public function payap_pdf(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['pays'] = MHPayAp::on(Auth::user()->db_name)->get();
        foreach($data['pays'] as $pap){
            $pap['outstanding'] = ($pap->mhpayapsubtotal - $pap->mhpayappayamount);
        }
        $pdf = PDF::loadview('admin/export/payap',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Pembayaran Hutang Dagang.pdf');
    }

    public function payap_excel(){
        $data['pays'] = MHPayAp::on(Auth::user()->db_name)->get();
        foreach($data['pays'] as $pap){
            $pap['outstanding'] = ($pap->mhpayapsubtotal - $pap->mhpayappayamount);
        }
        $this->pays = $data['pays'];
        $this->count =0;
        return Excel::create('Pembayaran Hutang Dagang',function($excel){
			$excel->sheet('Pembayaran Hutang Dagang',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Nomor Invoice','Nama Supplier','Tanggal','Pembayaran','Outstanding','Remarks'
				));
				foreach($this->pays as $p){
					$this->count++;
					$sheet->row($this->count,array(
						$p->mhpayapno,$p->mhpayapsuppliername,$p->mhpayapdate,$p->mhpayappayamount,$p['outstanding'],$p->mhpayapremarks
					));
				}
			});
		})->export('xls');
    }

    public function payap_csv(){
        $data['pays'] = MHPayAp::on(Auth::user()->db_name)->get();
        foreach($data['pays'] as $pap){
            $pap['outstanding'] = ($pap->mhpayapsubtotal - $pap->mhpayappayamount);
        }
        $this->pays = $data['pays'];
        $this->count =0;
        return Excel::create('Pembayaran Hutang Dagang',function($excel){
			$excel->sheet('Pembayaran Hutang Dagang',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Nomor Invoice','Nama Supplier','Tanggal','Pembayaran','Outstanding','Remarks'
				));
				foreach($this->pays as $p){
					$this->count++;
					$sheet->row($this->count,array(
						$p->mhpayapno,$p->mhpayapsuppliername,$p->mhpayapdate,$p->mhpayappayamount,$p['outstanding'],$p->mhpayapremarks
					));
				}
			});
		})->export('csv');
    }
}
