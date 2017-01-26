<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use Auth;
use App\MJournal;
use Carbon\Carbon;
use App\MCOA;
use PDF;
use Excel;

class LedgerController extends Controller
{
    public function ledger(){
        if(Auth::user()->has_role('R_ledger')){
            $data['active'] = 'ledger';
            $data['section'] = 'Buku Besar';
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            return view('admin.ledgerreport',$data);
        } else {
            return redirect('/admin-nano/index');    
        }

    }

    private function ledger_data($request){
        $ledger_query = MJournal::on(Auth::user()->db_name);
        $coa ="";
        if($request->has('bank') && $request->bank != 'Semua'){
            $coa = MCOA::on(Auth::user()->db_name)->where('id',$request->bank)->first()->mcoacode;
        }
        if($request->has('start')){
            $ledger_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
        }

        if($request->has('end')){
            $ledger_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
        }

        if($request->has('bank') && $request->bank != 'Semua'){
            $ledger_query->where('mjournalcoa',$coa);
        }

        $ledgers = [];

        $ledger_group = $ledger_query->groupBy('mjournalcoa')->orderBy('created_at','asc')->get();

        foreach($ledger_group as $grp){
            $group_data_query = MJournal::on(Auth::user()->db_name)->where('mjournalcoa',$grp->mjournalcoa);
            $debit = 0;
            $credit = 0;
            if($request->has('start')){
                $group_data_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                $group_data_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }
            $group_data = $group_data_query->get();
            foreach($group_data as $data){
                $data['data'] = true;
                $data['summary'] = false;
                $data['akun'] = MCOA::on(Auth::user()->db_name)->where('mcoacode',$data->mjournalcoa)->first();


                $debit += $data->mjournaldebit;
                $credit += $data->mjournalcredit;


                array_push($ledgers,$data);
            }
            $saldo = [
                'data' => false,
                'summary' => false,
                'debit' => $debit,
                'credit' => $credit
            ];
            array_push($ledgers,$saldo);
            if($debit > $credit){
                $summary = [
                    'data' => false,
                    'summary' => true,
                    'debit' => $debit - $credit,
                    'credit' => 0
                ];
            } else {
                $summary = [
                    'data' => false,
                    'summary' => true,
                    'debit' => 0,
                    'credit' => $credit - $debit
                ];
            }
            array_push($ledgers,$summary);
        }

        return $ledgers;
    }

    public function ledger_print(Request $request){
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['company'] = $data['config']->msyscompname;
        if($request->has('end')){
            $data['end'] = $request->end;
        } else {
            $data['end'] ="";
        }
        $data['ledgers'] = $this->ledger_data($request);
        return view('admin.export.ledgerreport',$data);
    }

    public function ledger_pdf(Request $request){
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['company'] = $data['config']->msyscompname;
        if($request->has('end')){
            $data['end'] = $request->end;
        } else {
            $data['end'] ="";
        }
        $data['ledgers'] = $this->ledger_data($request);
        $pdf = PDF::loadview('admin/export/ledgerreport',$data);
		return $pdf->setPaper('a4', 'landscape')->download('Buku Besar.pdf');
    }

    public function ledger_excel(Request $request){
        $this->data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $this->data['config']->msysgenrounddec;
        $this->data['dec_point'] = $this->data['config']->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['company'] = $this->data['config']->msyscompname;
        if($request->has('end')){
            $this->data['end'] = $request->end;
        } else {
            $this->data['end'] ="";
        }
        $this->data['ledgers'] = $this->ledger_data($request);
        $this->count =0;
        return Excel::create('Buku Besar',function($excel){
            $excel->sheet('Buku Besar',function($sheet){
                $this->count++;
                $sheet->mergeCells('A1:E1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Buku Besar'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count++;
                $sheet->mergeCells('A3:E3');
                $sheet->row($this->count,array('Per '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count+=1;

                $sheet->cell('E4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('E4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('E5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('E5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Tanggal','Akun','Tipe Transaksi','Debet','Credit'
                ));
                foreach($this->data['ledgers'] as $l){
                    $this->count++;
                    if($l['data'] == true){
                        $sheet->row($this->count,array(
                            $l->mjournaldate,
                            $l['akun']->mcoaname,
                            $l->mjournaltranstype,
                            $l->mjournaldebit,
                            $l->mjournalcredit
                        ));
                    } else if($l['data'] == false && $l['summary'] == false){
                        $sheet->row($this->count,array(
                            'Saldo',
                            '',
                            '',
                            $l['debit'],
                            $l['credit']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            '',
                            '',
                            $l['debit'],
                            $l['credit']
                        ));
                    }

                }
            });
        })->export('xls');
    }

    public function ledger_csv(Request $request){
        $this->data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $this->data['config']->msysgenrounddec;
        $this->data['dec_point'] = $this->data['config']->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['company'] = $this->data['config']->msyscompname;
        if($request->has('end')){
            $this->data['end'] = $request->end;
        } else {
            $this->data['end'] ="";
        }
        $this->data['ledgers'] = $this->ledger_data($request);
        $this->count =0;
        return Excel::create('Buku Besar',function($excel){
            $excel->sheet('Buku Besar',function($sheet){
                $this->count++;
                $sheet->mergeCells('A1:E1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Buku Besar'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count++;
                $sheet->mergeCells('A3:E3');
                $sheet->row($this->count,array('Per '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count+=1;

                $sheet->cell('E4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('E4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('E5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('E5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Tanggal','Akun','Tipe Transaksi','Debet','Credit'
                ));
                foreach($this->data['ledgers'] as $l){
                    $this->count++;
                    if($l['data'] == true){
                        $sheet->row($this->count,array(
                            $l->mjournaldate,
                            $l['akun']->mcoaname,
                            $l->mjournaltranstype,
                            $l->mjournaldebit,
                            $l->mjournalcredit
                        ));
                    } else if($l['data'] == false && $l['summary'] == false){
                        $sheet->row($this->count,array(
                            'Saldo',
                            '',
                            '',
                            $l['debit'],
                            $l['credit']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            '',
                            '',
                            $l['debit'],
                            $l['credit']
                        ));
                    }

                }
            });
        })->export('csv');
    }
}
