<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;
use PDF;
use Excel;
use Carbon\Carbon;
use App\MWarehouse;
use App\MBRANCH;
use App\MARCard;

class ARBookController extends Controller
{
    public function index(){
        if(Auth::user()->has_role('R_arreport')){
            $data['config'] = MConfig::on(Auth::user()->db_name)->first();
            $data['active'] = 'arbook';
            $data['section'] = 'Buku Piutang';
            return view('admin.arbookreport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function arbook_data($request,$opens){
        //fetch warehouses
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();

        $warehouses = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$branch->mbranchcode)->get();

        $warehouse_ids = array_map(function($w){
            return $w['id'];
        },$warehouses->toArray());

        $header_query = MARCard::on(Auth::user()->db_name)
        ->whereIn('marcardwarehouseid',$warehouse_ids)
        ->where('void',0);

        if($request->has('customer') && $request->customer != 'Semua'){
            $header_query->where('marcardcustomerid',$request->customer);
        }

        $ars = $header_query->groupBy('marcardcustomerid')->get();
        $ars_with_details_mixed = [];
        foreach($ars as $idx=>$ar){
            $ar['header'] = true;
            $ar['data'] = false;
            $ar['footer'] = false;
            $ar->marcardtotalinv = 0;
            $ar->marcardpayamount = 0;
            $ar->marcardoutstanding = 0;
            $pays = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$ar->marcardcustomerid)->where('void',0)->orderBy('marcardtransno','asc')->get();
            $current_inv = "";
            foreach($pays as $p){
                if($p->marcardtransno != $current_inv){
                    $ar->marcardtotalinv += $p->marcardtotalinv;
                    $current_inv = $p->marcardtransno;
                }
                $ar->marcardpayamount += $p->marcardpayamount;
                // $ar->marcardoutstanding += $p->marcardoutstanding;
            }
            $ar->marcardoutstanding = $ar->marcardtotalinv - $ar->marcardpayamount;
            array_push($ars_with_details_mixed,$ar);
            if(in_array($idx,$opens)){
                $pays = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$ar->marcardcustomerid)->where('void',0)->where('marcardpayamount','>',0)->orderBy('created_at','asc')->get();

                foreach ($pays as $p) {
                    $p['header'] = false;
                    $p['data'] = true;
                    $p['footer'] = false;

                    $p['inv_date'] = MARCard::on(Auth::user()->db_name)->where('marcardpayamount',0)->where('marcardtransno',$p->marcardtransno)->first()->marcarddate;

                    if($p->marcardpayamount == $p->marcardtotalinv){
                        $p['aging'] = 'Lunas';
                    } else {
                        $now = Carbon::now();
                        $due = Carbon::parse($p->marcardduedate);
                        $diff = $now->diffInDays($due,false);

                        $p['aging'] = $diff.' Hari';
                    }
                    array_push($ars_with_details_mixed,$p);
                }

                $footer = [
                    'header' => false,
                    'data' => false,
                    'footer' => true,
                ];

                array_push($ars_with_details_mixed,$footer);
            }
        }

        return $ars_with_details_mixed;
    }

    public function arbook_print(Request $request){
        $data_opens = $request->data;
        $data_opens = base64_decode($data_opens);
        $decoded_data = json_decode($data_opens);

        $data['ars'] = $this->arbook_data($request,$decoded_data);
        // dd($data);
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['company'] = $config->msyscompname;
        if($request->has('br')){
            $data['br'] = $request->br;
        }
        if($request->has('customer')){
            $data['cust'] = $request->customer;
        }
        $data['total_inv'] =0;
        $data['total_pay'] =0;
        $data['total_outs'] =0;
        foreach($data['ars'] as $ar){
            if($ar['header'] == true){
                $data['total_inv'] += $ar->marcardtotalinv;
                $data['total_pay'] += $ar->marcardpayamount;
                $data['total_outs'] += $ar->marcardoutstanding;
            }
        }
        return view('admin/export/arbook',$data);
    }

    public function arbook_pdf(Request $request){
        $data_opens = $request->data;
        $data_opens = base64_decode($data_opens);
        $decoded_data = json_decode($data_opens);

        $data['ars'] = $this->arbook_data($request,$decoded_data);
        // dd($data);
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['company'] = $config->msyscompname;
        if($request->has('br')){
            $data['br'] = $request->br;
        }
        if($request->has('customer')){
            $data['cust'] = $request->customer;
        }
        $data['total_inv'] =0;
        $data['total_pay'] =0;
        $data['total_outs'] =0;
        foreach($data['ars'] as $ar){
            if($ar['header'] == true){
                $data['total_inv'] += $ar->marcardtotalinv;
                $data['total_pay'] += $ar->marcardpayamount;
                $data['total_outs'] += $ar->marcardoutstanding;
            }
        }

        $pdf = PDF::loadview('admin/export/arbook',$data);
		return $pdf->setPaper('a4', 'landscape')->download('Laporan Buku Piutang.pdf');
    }

    public function arbook_excel(Request $request){

        $data_opens = $request->data;
        $data_opens = base64_decode($data_opens);
        $decoded_data = json_decode($data_opens);

        $this->data['ars'] = $this->arbook_data($request,$decoded_data);
        // dd($this->data);
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $config->msysgenrounddec;
        $this->data['dec_point'] = $config->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['company'] = $config->msyscompname;
        if($request->has('br')){
            $this->data['br'] = $request->br;
        }
        if($request->has('customer')){
            $this->data['cust'] = $request->customer;
        }
        $this->data['total_inv'] =0;
        $this->data['total_pay'] =0;
        $this->data['total_outs'] =0;
        foreach($this->data['ars'] as $ar){
            if($ar['header'] == true){
                $this->data['total_inv'] += $ar->marcardtotalinv;
                $this->data['total_pay'] += $ar->marcardpayamount;
                $this->data['total_outs'] += $ar->marcardoutstanding;
            }
        }

        $this->count = 0;
        $this->request = $request;
        return Excel::create('Laporan Buku Piutang',function($excel){
			$excel->sheet('Laporan Buku Piutang',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:K1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:K2');
                $sheet->row($this->count,array('Laporan Buku Piutang'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Cabang');
                });
                $sheet->cell('B4',function($cell){
                    if($this->request->has('br')){
                        $cell->setValue($this->request->br);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('I4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('J4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Customer');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('customer')){
                        $cell->setValue($this->request->customer);
                    } else {
                        $cell->setValue('Semua');
                    }
                });
                $sheet->cell('I5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('J5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Customer','Nama Customer','Tgl Pelunasan','No Invoice','Tgl Invoice','Tgl Jatuh Tempo','Nilai Inv','Nilai Bayar','Outstanding','Aging'
                ));
                foreach($this->data['ars'] as $ar){
                    $this->count++;
                    if($ar['header'] == true){
                        $sheet->row($this->count,array(
                            $ar['marcardcustomerid'],
                            $ar['marcardcustomername'],
                            '',
                            '',
                            '',
                            '',
                            $ar['marcardtotalinv'],
                            $ar['marcardpayamount'],
                            $ar['marcardoutstanding'],
                            ''
                        ));
                    } else if($ar['data'] == true){
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $ar['marcarddate'],
                            $ar['marcardtransno'],
                            $ar['inv_date'],
                            $ar['marcardduedate'],
                            $ar['marcardtotalinv'],
                            $ar['marcardpayamount'],
                            $ar['marcardoutstanding'],
                            $ar['aging']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            ''
                        ));
                    }

                }

                $this->count++;
                $sheet->row($this->count,array(
                    'Saldo',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->data['total_inv'],
                    $this->data['total_pay'],
                    $this->data['total_outs'],
                    ''
                ));

			});
		})->export('xls');
    }

    public function arbook_csv(Request $request){

        $data_opens = $request->data;
        $data_opens = base64_decode($data_opens);
        $decoded_data = json_decode($data_opens);

        $this->data['ars'] = $this->arbook_data($request,$decoded_data);
        // dd($this->data);
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $config->msysgenrounddec;
        $this->data['dec_point'] = $config->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['company'] = $config->msyscompname;
        if($request->has('br')){
            $this->data['br'] = $request->br;
        }
        if($request->has('customer')){
            $this->data['cust'] = $request->customer;
        }
        $this->data['total_inv'] =0;
        $this->data['total_pay'] =0;
        $this->data['total_outs'] =0;
        foreach($this->data['ars'] as $ar){
            if($ar['header'] == true){
                $this->data['total_inv'] += $ar->marcardtotalinv;
                $this->data['total_pay'] += $ar->marcardpayamount;
                $this->data['total_outs'] += $ar->marcardoutstanding;
            }
        }

        $this->count = 0;
        $this->request = $request;
        return Excel::create('Laporan Buku Piutang',function($excel){
			$excel->sheet('Laporan Buku Piutang',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:K1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:K2');
                $sheet->row($this->count,array('Laporan Buku Piutang'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Cabang');
                });
                $sheet->cell('B4',function($cell){
                    if($this->request->has('br')){
                        $cell->setValue($this->request->br);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('I4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('J4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Customer');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('customer')){
                        $cell->setValue($this->request->customer);
                    } else {
                        $cell->setValue('Semua');
                    }
                });
                $sheet->cell('I5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('J5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Customer','Nama Customer','Tgl Pelunasan','No Invoice','Tgl Invoice','Tgl Jatuh Tempo','Nilai Inv','Nilai Bayar','Outstanding','Aging'
                ));
                foreach($this->data['ars'] as $ar){
                    $this->count++;
                    if($ar['header'] == true){
                        $sheet->row($this->count,array(
                            $ar['marcardcustomerid'],
                            $ar['marcardcustomername'],
                            '',
                            '',
                            '',
                            '',
                            $ar['marcardtotalinv'],
                            $ar['marcardpayamount'],
                            $ar['marcardoutstanding'],
                            ''
                        ));
                    } else if($ar['data'] == true){
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $ar['marcarddate'],
                            $ar['marcardtransno'],
                            $ar['inv_date'],
                            $ar['marcardduedate'],
                            $ar['marcardtotalinv'],
                            $ar['marcardpayamount'],
                            $ar['marcardoutstanding'],
                            $ar['aging']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            ''
                        ));
                    }

                }

                $this->count++;
                $sheet->row($this->count,array(
                    'Saldo',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->data['total_inv'],
                    $this->data['total_pay'],
                    $this->data['total_outs'],
                    ''
                ));

			});
		})->export('csv');
    }
}
