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
        if($request->has('end')){
            $journal_query->whereDate('created_at','<=',Carbon::parse($request->end));
        }
        $journals = $journal_query->get();
        foreach($journals as $j){
            $j['akun'] = MCOA::on(Auth::user()->db_name)->where('mcoacode',$j->mjournalcoa)->first();
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
        $pdf = PDF::loadview('admin/export/journalreport',$data);
		return $pdf->setPaper('a4', 'landscape')->download('Jurnal.pdf');
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
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Jurnal'));
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
                $sheet->row($this->count,array(
                    'Tanggal','No Transaksi','Tipe','Akun','Debet','Credit'
                ));
                foreach($this->data['journals'] as $j){
                    $this->count++;
                    $sheet->row($this->count,array(
                        $j->mjournaldate,
                        $j->mjournaltransno,
                        $j->mjournaltype,
                        $j['akun']->mcoacode." - ".$j['akun']->mcoaname,
                        $j->mjournaldebit,
                        $j->mjournalcredit
                    ));
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
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Jurnal'));
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
                $sheet->row($this->count,array(
                    'Tanggal','No Transaksi','Tipe','Akun','Debet','Credit'
                ));
                foreach($this->data['journals'] as $j){
                    $this->count++;
                    $sheet->row($this->count,array(
                        $j->mjournaldate,
                        $j->mjournaltransno,
                        $j->mjournaltype,
                        $j['akun']->mcoacode." - ".$j['akun']->mcoaname,
                        $j->mjournaldebit,
                        $j->mjournalcredit
                    ));
                }
            });
        })->export('csv');
    }
}
