<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MCOA;
use App\MJournal;
use Carbon\Carbon;
use App\MConfig;
use PDF;
use Excel;

class CashBalanceReport extends Controller
{
    public function index(){
        if(Auth::user()->has_role('R_journal')){
            $data['active'] = 'cashbalance';
            $data['section'] = 'Neraca Saldo';
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            return view('admin.cashbalancereport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    private function cashbalance_data($request){
        $mcoa = MCOA::on(Auth::user()->db_name)->get();
        $filtered_coa = [];
        foreach($mcoa as $coa){
            $sum_debit = 0;
            $sum_credit = 0;
            $journal_query = MJournal::on(Auth::user()->db_name)->where('mjournalcoa',$coa->mcoacode);

            if($request->has('start')){
                $journal_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                $journal_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }

            $journals = $journal_query->get();

            foreach($journals as $j){
                $sum_debit += $j->mjournaldebit;
                $sum_credit += $j->mjournalcredit;
            }

            $coa['sum_debit'] = $sum_debit;
            $coa['sum_credit'] = $sum_credit;
            $coa['type'] = 'data';
            if($request->notzero == "true"){
                // dd(($sum_debit != 0) && ($sum_credit != 0));
                if(($sum_debit != 0) || ($sum_credit != 0)){
                    array_push($filtered_coa,$coa);
                }
            } else {
                array_push($filtered_coa,$coa);
            }
        }
        $sum_debit = 0;
        $sum_credit = 0;
        foreach ($filtered_coa as $key) {
            $sum_debit += $key['sum_debit'];
            $sum_credit += $key['sum_credit'];
        }

        $row_total = [
            'type' => "total",
            'sum_debit' => $sum_debit,
            'sum_credit' => $sum_credit
        ];

        array_push($filtered_coa,$row_total);

        return $filtered_coa;
    }

    public function cashbalance_print(Request $request){
        $data['journals'] = $this->cashbalance_data($request);
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $data['decimals'] = $conf->msysgenrounddec;
        $data['dec_point'] = $conf->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['company'] = $conf->msyscompname;
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        return view('admin.export.cashbalance',$data);
    }

    public function cashbalance_pdf(Request $request){
        $data['journals'] = $this->cashbalance_data($request);
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $data['decimals'] = $conf->msysgenrounddec;
        $data['dec_point'] = $conf->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['company'] = $conf->msyscompname;
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        $pdf = PDF::loadview('admin/export/cashbalance',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Cash Balance.pdf');
    }

    public function cashbalance_excel(Request $request){
        $this->data['journals'] = $this->cashbalance_data($request);
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $this->data['decimals'] = $conf->msysgenrounddec;
        $this->data['dec_point'] = $conf->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['company'] = $conf->msyscompname;
        $this->data['start'] = $request->start;
        $this->data['end'] = $request->end;

        $this->count = 0;
        return Excel::create('Cash Balance',function($excel){
			$excel->sheet('Cash Balance',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:D1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:D2');
                $sheet->row($this->count,array('Laporan Jurnal Penjualan'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:D3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('C4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('D4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('C5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('D5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Akun','Nama Akun','Debit','Kredit'
                ));
                foreach($this->data['journals'] as $j){
                    $this->count++;
                    if($j['type'] == 'data'){
                        $sheet->row($this->count,array(
                            $j->mcoacode,
                            $j->mcoaname,
                            $j['sum_debit'],
                            $j['sum_credit']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            'TOTAL',
                            '',
                            $j['sum_debit'],
                            $j['sum_credit']
                        ));
                    }
                }
			});
		})->export('xls');
    }

    public function cashbalance_csv(Request $request){
        $this->data['journals'] = $this->cashbalance_data($request);
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $this->data['decimals'] = $conf->msysgenrounddec;
        $this->data['dec_point'] = $conf->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['company'] = $conf->msyscompname;
        $this->data['start'] = $request->start;
        $this->data['end'] = $request->end;

        $this->count = 0;
        return Excel::create('Cash Balance',function($excel){
			$excel->sheet('Cash Balance',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:D1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:D2');
                $sheet->row($this->count,array('Laporan Jurnal Penjualan'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:D3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('C4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('D4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('C5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('D5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Akun','Nama Akun','Debit','Kredit'
                ));
                foreach($this->data['journals'] as $j){
                    $this->count++;
                    if($j['type'] == 'data'){
                        $sheet->row($this->count,array(
                            $j->mcoacode,
                            $j->mcoaname,
                            $j['sum_debit'],
                            $j['sum_credit']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            'TOTAL',
                            '',
                            $j['sum_debit'],
                            $j['sum_credit']
                        ));
                    }
                }
			});
		})->export('csv');
    }
}
