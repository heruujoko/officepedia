<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use App\HPPHistory;
use Carbon\Carbon;
use Auth;
use PDF;
use Excel;
use App\MGoods;

class COGSHistoryController extends Controller
{
    public function cogshistory(){
        $data['active'] = 'cogshistory';
        $data['section'] = 'Laporan History HPP';
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.cogshistory',$data);
    }

    public function cogshistory_print(Request $request){
        $history_query = HPPHistory::on(Auth::user()->db_name);

        if($request->has('goods')){
            $history_query->where('hpphistorygoodsid',$request->goods);
        }

        if($request->has('end')){
            $history_query->whereDate('created_at','<=',Carbon::parse($request->end));
        }

        $histories = $history_query->groupBy('hpphistorygoodsid')->get();

        $history_data = [];

        foreach($histories as $h){
            $header = [
                'data' => 'header',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname
            ];
            $qtys = 0;
            array_push($history_data,$header);
            $childs_q = HPPHistory::on(Auth::user()->db_name)->where('void',0)->where('hpphistorygoodsid',$h->hpphistorygoodsid);
            if($request->has('end')){
                $childs_q->whereDate('created_at','<=',Carbon::parse($request->end));
            }
            $childs = $childs_q->get();
            foreach($childs as $ch){
                $ch['data'] = 'data';
                if($ch->type == 'purchase'){
                    $qtys += $ch->usage;
                } else {
                    $qtys -= $ch->usage;
                }
                array_push($history_data,$ch);
            }

            $footer = [
                'data' => 'footer',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname,
                'hpphistoryqty' => $qtys,
                'hpphistorycogs' => $childs->last()->hpphistorycogs
            ];
            array_push($history_data,$footer);

        }

        $data['histories'] = $history_data;

        if($request->has('goods')){
            $g = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$request->goods)->first();
            $data['goods'] = $g['mgoodscode'].' / '.$g['mgoodsname'];
        } else {
            $data['goods'] = "Semua";
        }

        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['end'] = $request->end;
        $data['company'] = $data['config']->msyscompname;

        return view('admin.export.cogshistory',$data);
    }

    public function cogshistory_pdf(Request $request){
        $history_query = HPPHistory::on(Auth::user()->db_name);

        if($request->has('goods')){
            $history_query->where('hpphistorygoodsid',$request->goods);
        }

        if($request->has('end')){
            $history_query->whereDate('created_at','<=',Carbon::parse($request->end));
        }

        $histories = $history_query->groupBy('hpphistorygoodsid')->get();

        $history_data = [];

        foreach($histories as $h){
            $header = [
                'data' => 'header',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname
            ];
            $qtys = 0;
            array_push($history_data,$header);
            $childs_q = HPPHistory::on(Auth::user()->db_name)->where('void',0)->where('hpphistorygoodsid',$h->hpphistorygoodsid);
            if($request->has('end')){
                $childs_q->whereDate('created_at','<=',Carbon::parse($request->end));
            }
            $childs = $childs_q->get();
            foreach($childs as $ch){
                $ch['data'] = 'data';
                if($ch->type == 'purchase'){
                    $qtys += $ch->usage;
                } else {
                    $qtys -= $ch->usage;
                }
                array_push($history_data,$ch);
            }

            $footer = [
                'data' => 'footer',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname,
                'hpphistoryqty' => $qtys,
                'hpphistorycogs' => $childs->last()->hpphistorycogs
            ];
            array_push($history_data,$footer);

        }

        $data['histories'] = $history_data;

        if($request->has('goods')){
            $g = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$request->goods)->first();
            $data['goods'] = $g['mgoodscode'].' / '.$g['mgoodsname'];
        } else {
            $data['goods'] = "Semua";
        }

        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $data['config']->msysgenrounddec;
        $data['dec_point'] = $data['config']->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['end'] = $request->end;
        $data['company'] = $data['config']->msyscompname;

        $pdf = PDF::loadview('admin/export/cogshistory',$data);
		return $pdf->setPaper('a4', 'landscape')->download('Laporan History HPP.pdf');
    }

    public function cogshistory_excel(Request $request){
        $history_query = HPPHistory::on(Auth::user()->db_name);

        if($request->has('goods')){
            $history_query->where('hpphistorygoodsid',$request->goods);
        }

        if($request->has('end')){
            $history_query->whereDate('created_at','<=',Carbon::parse($request->end));
        }

        $histories = $history_query->groupBy('hpphistorygoodsid')->get();

        $history_data = [];

        foreach($histories as $h){
            $header = [
                'data' => 'header',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname
            ];
            $qtys = 0;
            array_push($history_data,$header);
            $childs_q = HPPHistory::on(Auth::user()->db_name)->where('void',0)->where('hpphistorygoodsid',$h->hpphistorygoodsid);
            if($request->has('end')){
                $childs_q->whereDate('created_at','<=',Carbon::parse($request->end));
            }
            $childs = $childs_q->get();
            foreach($childs as $ch){
                $ch['data'] = 'data';
                if($ch->type == 'purchase'){
                    $qtys += $ch->usage;
                } else {
                    $qtys -= $ch->usage;
                }
                array_push($history_data,$ch);
            }

            $footer = [
                'data' => 'footer',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname,
                'hpphistoryqty' => $qtys,
                'hpphistorycogs' => $childs->last()->hpphistorycogs
            ];
            array_push($history_data,$footer);

        }

        $this->data['histories'] = $history_data;

        if($request->has('goods')){
            $g = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$request->goods)->first();
            $this->data['goods'] = $g['mgoodscode'].' / '.$g['mgoodsname'];
        } else {
            $this->data['goods'] = "Semua";
        }

        $this->data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $this->data['config']->msysgenrounddec;
        $this->data['dec_point'] = $this->data['config']->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['end'] = $request->end;
        $this->data['company'] = $this->data['config']->msyscompname;

        $this->count = 0;
        return Excel::create('Laporan History HPP',function($excel){
			$excel->sheet('Laporan History HPP',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:E1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Laporan History HPP'));
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

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Cabang');
                });
                $sheet->cell('B4',function($cell){
                    $cell->setValue($this->data['goods']);
                });

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
                    'Kode Barang','Nama Barang','Qty','Harga Beli','Pembelian','HPP','Remark'
                ));
                foreach($this->data['histories'] as $h){
                    $this->count++;
                    if($h['data'] == 'header'){
                        $sheet->row($this->count,array(
                            $h['hpphistorygoodsid'],
                            $h['name'],
                            '',
                            '',
                            '',
                            ''
                        ));
                    } else if($h['data'] == 'data'){
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $h->usage,
                            $h->buyprice,
                            $h->hpphistorypurchase,
                            $h->hpphistorycogs,
                            $h->hpphistoryremarks
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            'TOTAL',
                            '',
                            $h['hpphistoryqty'],
                            '',
                            '',
                            $h['hpphistorycogs'],
                            ''
                        ));
                    }
                }
			});
		})->export('xls');
    }

    public function cogshistory_csv(Request $request){
        $history_query = HPPHistory::on(Auth::user()->db_name);

        if($request->has('goods')){
            $history_query->where('hpphistorygoodsid',$request->goods);
        }

        if($request->has('end')){
            $history_query->whereDate('created_at','<=',Carbon::parse($request->end));
        }

        $histories = $history_query->groupBy('hpphistorygoodsid')->get();

        $history_data = [];

        foreach($histories as $h){
            $header = [
                'data' => 'header',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname
            ];
            $qtys = 0;
            array_push($history_data,$header);
            $childs_q = HPPHistory::on(Auth::user()->db_name)->where('void',0)->where('hpphistorygoodsid',$h->hpphistorygoodsid);
            if($request->has('end')){
                $childs_q->whereDate('created_at','<=',Carbon::parse($request->end));
            }
            $childs = $childs_q->get();
            foreach($childs as $ch){
                $ch['data'] = 'data';
                if($ch->type == 'purchase'){
                    $qtys += $ch->usage;
                } else {
                    $qtys -= $ch->usage;
                }
                array_push($history_data,$ch);
            }

            $footer = [
                'data' => 'footer',
                'hpphistorygoodsid' => $h->hpphistorygoodsid,
                'name' => $h->goods()->mgoodsname,
                'hpphistoryqty' => $qtys,
                'hpphistorycogs' => $childs->last()->hpphistorycogs
            ];
            array_push($history_data,$footer);

        }

        $this->data['histories'] = $history_data;

        if($request->has('goods')){
            $g = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$request->goods)->first();
            $this->data['goods'] = $g['mgoodscode'].' / '.$g['mgoodsname'];
        } else {
            $this->data['goods'] = "Semua";
        }

        $this->data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $this->data['config']->msysgenrounddec;
        $this->data['dec_point'] = $this->data['config']->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['end'] = $request->end;
        $this->data['company'] = $this->data['config']->msyscompname;

        $this->count = 0;
        return Excel::create('Laporan History HPP',function($excel){
			$excel->sheet('Laporan History HPP',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:E1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Laporan History HPP'));
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

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Cabang');
                });
                $sheet->cell('B4',function($cell){
                    $cell->setValue($this->data['goods']);
                });

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
                    'Kode Barang','Nama Barang','Qty','Harga Beli','Pembelian','HPP','Remark'
                ));
                foreach($this->data['histories'] as $h){
                    $this->count++;
                    if($h['data'] == 'header'){
                        $sheet->row($this->count,array(
                            $h['hpphistorygoodsid'],
                            $h['name'],
                            '',
                            '',
                            '',
                            ''
                        ));
                    } else if($h['data'] == 'data'){
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $h->usage,
                            $h->buyprice,
                            $h->hpphistorypurchase,
                            $h->hpphistorycogs,
                            $h->hpphistoryremarks
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            'TOTAL',
                            '',
                            $h['hpphistoryqty'],
                            '',
                            '',
                            $h['hpphistorycogs'],
                            ''
                        ));
                    }
                }
			});
		})->export('csv');
    }
}
