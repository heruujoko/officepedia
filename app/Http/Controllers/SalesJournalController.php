<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\MConfig;
use App\Http\Requests;
use App\MJournal;
use App\MCOA;
use Excel;
use PDF;
use Carbon\Carbon;

class SalesJournalController extends Controller
{
    public function index(){
        if(Auth::user()->has_role('R_journal')){
            $data['active'] = 'salesjournal';
            $data['section'] = 'Jurnal Penjualan';
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            return view('admin.salesjournalreport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    private function salesjournal_data($request){
        $header_query = MJournal::on(Auth::user()->db_name)->where('mjournaltranstype','Penjualan');

        if($request->has('start')){
            $header_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
        }
        if($request->has('end')){
            $header_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
        }

        $headers = $header_query->groupBy('mjournalid')->get();
        $groups = [];
        foreach($headers as $h){
            $detail_query = MJournal::on(Auth::user()->db_name)->where('mjournaltranstype','Penjualan')->where('mjournaltransno',$h->mjournaltransno);

            if($request->has('start')){
                $header_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                $header_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }

            $details = $detail_query->get();

            $sum_debit = 0;
            $sum_credit = 0;

            foreach ($details as $d) {
                $d['mjournalcoaname'] = MCOA::on(Auth::user()->db_name)->where('mcoacode',$d->mjournalcoa)->first()->mcoaname;
                $sum_debit += $d->mjournaldebit;
                $sum_credit += $d->mjournalcredit;
            }

            $data = [
                'date' => $h->mjournaldate,
                'type' => $h->mjournaltranstype,
                'trans' => $h->mjournaltransno,
                'sum_debit' => $sum_debit,
                'sum_credit' => $sum_credit,
                'transactions' => $details
            ];

            array_push($groups,$data);
        }

        return $groups;
    }

    public function salesjournal_print(Request $request){
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $data['decimals'] = $conf->msysgenrounddec;
        $data['dec_point'] = $conf->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['journals'] = $this->salesjournal_data($request);
        $data['mode'] = 'Pembelian';
        $data['company'] = $conf->msyscompname;
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        return view('admin.export.salespurchasejournal',$data);
    }

    public function salesjournal_pdf(Request $request){
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $data['decimals'] = $conf->msysgenrounddec;
        $data['dec_point'] = $conf->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['journals'] = $this->salesjournal_data($request);
        $data['mode'] = 'Pembelian';
        $data['company'] = $conf->msyscompname;
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        $pdf = PDF::loadview('admin/export/salespurchasejournal',$data);
		return $pdf->setPaper('a4', 'portrait')->download('Sales Journal.pdf');
    }

    public function salesjournal_excel(Request $request){
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $this->data['decimals'] = $conf->msysgenrounddec;
        $this->data['dec_point'] = $conf->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['journals'] = $this->salesjournal_data($request);
        $this->data['mode'] = 'Pembelian';
        $this->data['company'] = $conf->msyscompname;
        $this->data['start'] = $request->start;
        $this->data['end'] = $request->end;
        $this->count = 0;
        return Excel::create('Purchase Journal',function($excel){
			$excel->sheet('Purchase Journal',function($sheet){
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
                        'Kode Akun','Nama Akun','Debit','Kredit'
                    ));
                    $this->count++;
                    foreach($j['transactions'] as $tr){
                        $sheet->row($this->count,array(
                            $tr->mjournalcoa,$tr['mjournalcoaname'],$tr->mjournaldebit,$tr->mjournalcredit
                        ));
                        $this->count++;
                    }
                    $sheet->row($this->count,array(
                        '','',$j['sum_debit'],$j['sum_credit']
                    ));
                    $this->count+=2;
                }
			});
		})->export('xls');
    }

    public function salesjournal_csv(Request $request){
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $this->data['decimals'] = $conf->msysgenrounddec;
        $this->data['dec_point'] = $conf->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['journals'] = $this->salesjournal_data($request);
        $this->data['mode'] = 'Pembelian';
        $this->data['company'] = $conf->msyscompname;
        $this->data['start'] = $request->start;
        $this->data['end'] = $request->end;
        $this->count = 0;
        return Excel::create('Purchase Journal',function($excel){
			$excel->sheet('Purchase Journal',function($sheet){
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
                        'Kode Akun','Nama Akun','Debit','Kredit'
                    ));
                    $this->count++;
                    foreach($j['transactions'] as $tr){
                        $sheet->row($this->count,array(
                            $tr->mjournalcoa,$tr['mjournalcoaname'],$tr->mjournaldebit,$tr->mjournalcredit
                        ));
                        $this->count++;
                    }
                    $sheet->row($this->count,array(
                        '','',$j['sum_debit'],$j['sum_credit']
                    ));
                    $this->count+=2;
                }
			});
		})->export('csv');
    }
}
