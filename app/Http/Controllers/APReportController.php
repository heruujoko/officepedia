<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MConfig;
use Auth;
use App\Http\Requests;
use App\MAPCard;
use Carbon\Carbon;
use PDF;
use Excel;

class APReportController extends Controller
{
    public function apreport(Request $request){

        if(Auth::user()->has_role('R_apreport')){
            $data['active'] = 'apreport';
            $data['section'] = 'Laporan Hutang Dagang';
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            return view('admin.apreport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function apreport_print(Request $request){
        $header_query = MAPCard::on(Auth::user()->db_name);

        if($request->has('br')){

        }

        if($request->has('spl')){
            $header_query->where('mapcardsupplierid',$request->spl);
        }

        $headers = $header_query->groupBy('mapcardsupplierid')->orderBy('created_at')->get();
        $dates = [];
        foreach($headers as $hd){
            array_push($dates,array('mapcardsupplierid' => $hd->mapcardsupplierid,'mapcardsuppliername' => $hd->mapcardsuppliername));
        }
        $reports = [];
        foreach($dates as $d){
            $h = array(
                'data' => false,
                'footer' => false,
                'mapcardsupplierid' => $d['mapcardsupplierid'],
                'mapcardsuppliername' => $d['mapcardsuppliername'],
            );
            array_push($reports,$h);
            $dtl = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$d['mapcardsupplierid'])->orderBy('created_at')->get();
            $total_inv = 0;
            $total_outstanding = 0;
            foreach ($dtl as $dt) {
                $dt['data'] = true;
                $dt['aging'] = Carbon::parse($dt->mapcardtdate)->diffInDays(Carbon::now());
                $dt['footer'] = false;
                $total_inv += $dt->mapcardtotalinv;
                $total_outstanding += $dt->mapcardoutstanding;
                array_push($reports,$dt);
            }
            $footer = array(
                'data' =>false,
                'footer' => true,
                'total_inv' => $total_inv,
                'total_outstanding' => $total_outstanding
            );
            array_push($reports,$footer);
        }

        $data['aps'] = $reports;
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['spl'] = 'Semua';
        $data['goods'] = 'Semua';
        $data['br'] = 'Semua';
        $data['wh'] = 'Semua';
        $data['end'] = $request->end;
        $data['company'] = $data['config']->msyscompname;

        $data['total_iv'] =0;
        $data['total_out'] =0;

        foreach ($data['aps'] as $ap) {
            if($ap['data'] == true){
                $data['total_iv'] += $ap->mapcardtotalinv;
                $data['total_out'] += $ap->mapcardoutstanding;
            }
        }

        return view('admin.export.apreport',$data);
    }

    public function apreport_pdf(Request $request){
        $header_query = MAPCard::on(Auth::user()->db_name);

        if($request->has('br')){

        }

        if($request->has('spl')){
            $header_query->where('mapcardsupplierid',$request->spl);
        }

        $headers = $header_query->groupBy('mapcardsupplierid')->orderBy('created_at')->get();
        $dates = [];
        foreach($headers as $hd){
            array_push($dates,array('mapcardsupplierid' => $hd->mapcardsupplierid,'mapcardsuppliername' => $hd->mapcardsuppliername));
        }
        $reports = [];
        foreach($dates as $d){
            $h = array(
                'data' => false,
                'footer' => false,
                'mapcardsupplierid' => $d['mapcardsupplierid'],
                'mapcardsuppliername' => $d['mapcardsuppliername'],
            );
            array_push($reports,$h);
            $dtl = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$d['mapcardsupplierid'])->orderBy('created_at')->get();
            $total_inv = 0;
            $total_outstanding = 0;
            foreach ($dtl as $dt) {
                $dt['data'] = true;
                $dt['aging'] = Carbon::parse($dt->mapcardtdate)->diffInDays(Carbon::now());
                $dt['footer'] = false;
                $total_inv += $dt->mapcardtotalinv;
                $total_outstanding += $dt->mapcardoutstanding;
                array_push($reports,$dt);
            }
            $footer = array(
                'data' =>false,
                'footer' => true,
                'total_inv' => $total_inv,
                'total_outstanding' => $total_outstanding
            );
            array_push($reports,$footer);
        }

        $data['aps'] = $reports;
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['spl'] = 'Semua';
        $data['goods'] = 'Semua';
        $data['br'] = 'Semua';
        $data['wh'] = 'Semua';
        $data['end'] = $request->end;
        $data['company'] = $data['config']->msyscompname;

        $data['total_iv'] =0;
        $data['total_out'] =0;

        foreach ($data['aps'] as $ap) {
            if($ap['data'] == true){
                $data['total_iv'] += $ap->mapcardtotalinv;
                $data['total_out'] += $ap->mapcardoutstanding;
            }
        }

        $pdf = PDF::loadview('admin/export/apreport',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Laporan Hutang Dagang.pdf');
    }

    public function apreport_excel(Request $request){
        $header_query = MAPCard::on(Auth::user()->db_name);

        if($request->has('br')){

        }

        if($request->has('spl')){
            $header_query->where('mapcardsupplierid',$request->spl);
        }

        $headers = $header_query->groupBy('mapcardsupplierid')->orderBy('created_at')->get();
        $dates = [];
        foreach($headers as $hd){
            array_push($dates,array('mapcardsupplierid' => $hd->mapcardsupplierid,'mapcardsuppliername' => $hd->mapcardsuppliername));
        }
        $reports = [];
        foreach($dates as $d){
            $h = array(
                'data' => false,
                'footer' => false,
                'mapcardsupplierid' => $d['mapcardsupplierid'],
                'mapcardsuppliername' => $d['mapcardsuppliername'],
            );
            array_push($reports,$h);
            $dtl = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$d['mapcardsupplierid'])->orderBy('created_at')->get();
            $total_inv = 0;
            $total_outstanding = 0;
            foreach ($dtl as $dt) {
                $dt['data'] = true;
                $dt['aging'] = Carbon::parse($dt->mapcardtdate)->diffInDays(Carbon::now());
                $dt['footer'] = false;
                $total_inv += $dt->mapcardtotalinv;
                $total_outstanding += $dt->mapcardoutstanding;
                array_push($reports,$dt);
            }
            $footer = array(
                'data' =>false,
                'footer' => true,
                'total_inv' => $total_inv,
                'total_outstanding' => $total_outstanding
            );
            array_push($reports,$footer);
        }

        $this->data['aps'] = $reports;
        $this->data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $this->data['config']->msysgenrounddec;
        $this->data['dec_point'] = $this->data['config']->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }

        $this->data['spl'] = 'Semua';
        $this->data['goods'] = 'Semua';
        $this->data['br'] = 'Semua';
        $this->data['wh'] = 'Semua';
        $this->data['end'] = $request->end;
        $this->data['start'] = $request->start;
        $this->data['company'] = $this->data['config']->msyscompname;

        $this->data['total_iv'] =0;
        $this->data['total_out'] =0;

        foreach ($this->data['aps'] as $ap) {
            if($ap['data'] == true){
                $this->data['total_iv'] += $ap->mapcardtotalinv;
                $this->data['total_out'] += $ap->mapcardoutstanding;
            }
        }

        $this->data['total'] =0;
        $this->count = 0;
        return Excel::create('Laporan Hutang Dagang',function($excel){
			$excel->sheet('Laporan Hutang Dagang',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:E1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Laporan Hutang Dagang'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count++;
                $sheet->mergeCells('A3:E3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count+=1;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Cabang');
                });
                $sheet->cell('B4',function($cell){
                    $cell->setValue('Semua');
                });

                $sheet->cell('D4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('E4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Supplier');
                });
                $sheet->cell('B5',function($cell){
                    $cell->setValue($this->data['spl']);
                });
                $sheet->cell('D5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('E5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Supplier','Nama Supplier','No Pembelian','Tgl Invoice','Tgl Jatuh Tempo','Nilai Pembelian','Outstanding','Aging'
                ));
                foreach($this->data['aps'] as $sv){
                    $this->count++;
                    if($sv['data'] == false && $sv['footer'] == false){
                        $sheet->row($this->count,array(
                            $sv['mapcardsupplierid'],
                            $sv['mapcardsuppliername'],
                        ));
                    } else if($sv['footer'] == true){
                        $sheet->row($this->count,array(
                            'Total',
                            '',
                            '',
                            '',
                            '',
                            $sv['total_inv'],
                            $sv['total_outstanding'],
                            ''
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $sv->mapcardtransno,
                            $sv->mapcardtdate,
                            $sv->mapcardduedate,
                            $sv->mapcardtotalinv,
                            $sv->mapcardoutstanding,
                            $sv->aging
                        ));
                    }

                }

                $this->count++;
                $sheet->row($this->count,array(
                    'Grand Total',
                    '',
                    '',
                    '',
                    '',
                    $this->data['total_iv'],
                    $this->data['total_out']
                ));

			});
		})->export('xls');
    }

    public function apreport_csv(Request $request){
        $header_query = MAPCard::on(Auth::user()->db_name);

        if($request->has('br')){

        }

        if($request->has('spl')){
            $header_query->where('mapcardsupplierid',$request->spl);
        }

        $headers = $header_query->groupBy('mapcardsupplierid')->orderBy('created_at')->get();
        $dates = [];
        foreach($headers as $hd){
            array_push($dates,array('mapcardsupplierid' => $hd->mapcardsupplierid,'mapcardsuppliername' => $hd->mapcardsuppliername));
        }
        $reports = [];
        foreach($dates as $d){
            $h = array(
                'data' => false,
                'footer' => false,
                'mapcardsupplierid' => $d['mapcardsupplierid'],
                'mapcardsuppliername' => $d['mapcardsuppliername'],
            );
            array_push($reports,$h);
            $dtl = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$d['mapcardsupplierid'])->orderBy('created_at')->get();
            $total_inv = 0;
            $total_outstanding = 0;
            foreach ($dtl as $dt) {
                $dt['data'] = true;
                $dt['aging'] = Carbon::parse($dt->mapcardtdate)->diffInDays(Carbon::now());
                $dt['footer'] = false;
                $total_inv += $dt->mapcardtotalinv;
                $total_outstanding += $dt->mapcardoutstanding;
                array_push($reports,$dt);
            }
            $footer = array(
                'data' =>false,
                'footer' => true,
                'total_inv' => $total_inv,
                'total_outstanding' => $total_outstanding
            );
            array_push($reports,$footer);
        }

        $this->data['aps'] = $reports;
        $this->data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $this->data['config']->msysgenrounddec;
        $this->data['dec_point'] = $this->data['config']->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }

        $this->data['spl'] = 'Semua';
        $this->data['goods'] = 'Semua';
        $this->data['br'] = 'Semua';
        $this->data['wh'] = 'Semua';
        $this->data['end'] = $request->end;
        $this->data['start'] = $request->start;
        $this->data['company'] = $this->data['config']->msyscompname;

        $this->data['total_iv'] =0;
        $this->data['total_out'] =0;

        foreach ($this->data['aps'] as $ap) {
            if($ap['data'] == true){
                $this->data['total_iv'] += $ap->mapcardtotalinv;
                $this->data['total_out'] += $ap->mapcardoutstanding;
            }
        }

        $this->data['total'] =0;
        $this->count = 0;
        return Excel::create('Laporan Hutang Dagang',function($excel){
			$excel->sheet('Laporan Hutang Dagang',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:E1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Laporan Hutang Dagang'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count++;
                $sheet->mergeCells('A3:E3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count+=1;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Cabang');
                });
                $sheet->cell('B4',function($cell){
                    $cell->setValue('Semua');
                });

                $sheet->cell('D4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('E4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Supplier');
                });
                $sheet->cell('B5',function($cell){
                    $cell->setValue($this->data['spl']);
                });
                $sheet->cell('D5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('E5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Supplier','Nama Supplier','No Pembelian','Tgl Invoice','Tgl Jatuh Tempo','Nilai Pembelian','Outstanding','Aging'
                ));
                foreach($this->data['aps'] as $sv){
                    $this->count++;
                    if($sv['data'] == false && $sv['footer'] == false){
                        $sheet->row($this->count,array(
                            $sv['mapcardsupplierid'],
                            $sv['mapcardsuppliername'],
                        ));
                    } else if($sv['footer'] == true){
                        $sheet->row($this->count,array(
                            'Total',
                            '',
                            '',
                            '',
                            '',
                            $sv['total_inv'],
                            $sv['total_outstanding'],
                            ''
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $sv->mapcardtransno,
                            $sv->mapcardtdate,
                            $sv->mapcardduedate,
                            $sv->mapcardtotalinv,
                            $sv->mapcardoutstanding,
                            $sv->aging
                        ));
                    }

                }

                $this->count++;
                $sheet->row($this->count,array(
                    'Grand Total',
                    '',
                    '',
                    '',
                    '',
                    $this->data['total_iv'],
                    $this->data['total_out']
                ));

			});
		})->export('csv');
    }

}
