<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;
use PDF;
use Excel;
use App\MJournal;
use App\MCOA;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function journal(){

        if(Auth::user()->has_role('R_journal')){
            $data['active'] = 'journal';
            $data['section'] = 'Jurnal';
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            return view('admin.journalreport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    private function journal_data($request){
        $journal_query = MJournal::on(Auth::user()->db_name)->where('void',0);
        if($request->has('start')){
            $journal_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
        }
        if($request->has('end')){
            $journal_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
        }
        $headers = $journal_query->groupBy('mjournalid')->get();
        $journals = [];

        foreach($headers as $h){

            $group_query = MJournal::on(Auth::user()->db_name)->where('mjournalid',$h->mjournalid);

            if($request->has('start')){
                $journal_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                $journal_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }

            $groups = $group_query->get();

            $sum_debit = 0;
            $sum_credit = 0;

            foreach($groups as $g){
                $sum_debit += $g->mjournaldebit;
                $sum_credit += $g->mjournalcredit;
                $g['mjournalcoaname'] = MCOA::on(Auth::user()->db_name)->where('mcoacode',$g->mjournalcoa)->first()->mcoaname;
            }

            $data = [
                'date' => $h->mjournaldate,
                'type' => $h->mjournaltranstype,
                'trans' => $h->mjournaltransno,
                'sum_debit' => $sum_debit,
                'sum_credit' => $sum_credit,
                'transactions' => $groups
            ];

            array_push($journals,$data);
        }

        return $journals;
    }

    public function journal_print(Request $request){
        $data['journals'] = $this->journal_data($request);
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
        if($request->has('start')){
            $data['start'] = $request->start;
        } else {
            $data['start'] ="";
        }
        return view('admin.export.journalreport',$data);
    }

    public function journal_pdf(Request $request){
        $data['journals'] = $this->journal_data($request);
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
        if($request->has('start')){
            $data['start'] = $request->start;
        } else {
            $data['start'] ="";
        }
        $pdf = PDF::loadview('admin/export/journalreport',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Jurnal.pdf');
    }

    public function journal_excel(Request $request){
        $this->data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['company'] = $this->data['config']->msyscompname;
        $this->count = 0;
        $this->data['end'] = $request->end;
        $this->data['journals'] = $this->journal_data($request);

        return Excel::create('Jurnal',function($excel){
            $excel->sheet('Jurnal',function($sheet){
                $this->count++;
                $sheet->mergeCells('A1:F1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:F2');
                $sheet->row($this->count,array('Jurnal'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count++;
                $sheet->mergeCells('A3:F3');
                $sheet->row($this->count,array('Per '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count+=1;

                $sheet->cell('E4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('F4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('E5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('F5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                foreach($this->data['journals'] as $j){
                    $sheet->row($this->count,array(
                        'Tanggal',$j['date']
                    ));
                    $this->count++;
                    $sheet->row($this->count,array(
                        'Tipe Transaksi',$j['type']
                    ));
                    $this->count++;
                    $sheet->row($this->count,array(
                        'No Transaksi',$j['trans']
                    ));
                    $this->count+=2;

                    $sheet->row($this->count,array(
                        'Tanggal','No Transaksi','Tipe','Akun','Debet','Credit'
                    ));
                    foreach($j['transactions'] as $tr){
                        $this->count++;
                        if($tr->mjournalcredit != 0){
                            $sheet->row($this->count,array(
                                $tr->mjournaldate,
                                $tr->mjournaltransno,
                                $tr->mjournaltype,
                                '                 '.$tr['mjournalcoaname'],
                                $tr->mjournaldebit,
                                $tr->mjournalcredit
                            ));
                        } else {
                            $sheet->row($this->count,array(
                                $tr->mjournaldate,
                                $tr->mjournaltransno,
                                $tr->mjournaltype,
                                $tr['mjournalcoaname'],
                                $tr->mjournaldebit,
                                $tr->mjournalcredit
                            ));
                        }
                    }
                    $this->count++;
                    $sheet->row($this->count,array(
                        '','','','',$j['sum_debit'],$j['sum_credit']
                    ));
                    $this->count+=2;
                }
            });
        })->export('xls');
    }

    public function journal_csv(Request $request){
        $this->data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['company'] = $this->data['config']->msyscompname;
        $this->count = 0;
        $this->data['end'] = $request->end;
        $this->data['journals'] = $this->journal_data($request);

        return Excel::create('Jurnal',function($excel){
            $excel->sheet('Jurnal',function($sheet){
                $this->count++;
                $sheet->mergeCells('A1:F1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:F2');
                $sheet->row($this->count,array('Jurnal'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count++;
                $sheet->mergeCells('A3:F3');
                $sheet->row($this->count,array('Per '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count+=1;

                $sheet->cell('E4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('F4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('E5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('F5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                foreach($this->data['journals'] as $j){
                    $sheet->row($this->count,array(
                        'Tanggal',$j['date']
                    ));
                    $this->count++;
                    $sheet->row($this->count,array(
                        'Tipe Transaksi',$j['type']
                    ));
                    $this->count++;
                    $sheet->row($this->count,array(
                        'No Transaksi',$j['trans']
                    ));
                    $this->count+=2;

                    $sheet->row($this->count,array(
                        'Tanggal','No Transaksi','Tipe','Akun','Debet','Credit'
                    ));
                    foreach($j['transactions'] as $tr){
                        $this->count++;
                        if($tr->mjournalcredit != 0){
                            $sheet->row($this->count,array(
                                $tr->mjournaldate,
                                $tr->mjournaltransno,
                                $tr->mjournaltype,
                                '                 '.$tr['mjournalcoaname'],
                                $tr->mjournaldebit,
                                $tr->mjournalcredit
                            ));
                        } else {
                            $sheet->row($this->count,array(
                                $tr->mjournaldate,
                                $tr->mjournaltransno,
                                $tr->mjournaltype,
                                $tr['mjournalcoaname'],
                                $tr->mjournaldebit,
                                $tr->mjournalcredit
                            ));
                        }
                    }
                    $this->count++;
                    $sheet->row($this->count,array(
                        '','','','',$j['sum_debit'],$j['sum_credit']
                    ));
                    $this->count+=2;
                }
            });
        })->export('csv');
    }
}
