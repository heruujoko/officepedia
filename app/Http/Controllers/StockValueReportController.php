<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use Auth;
use App\MSupplier;
use DB;
use PDF;
use Excel;
use App\Helper\UnitHelper;
use Carbon\Carbon;

class StockValueReportController extends Controller
{
    public function stockvalue(){
        $data['active'] = 'stockvalue';
        $data['section'] = 'Nilai Persediaan';
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.stockvaluereport',$data);
    }

    public function stockvalue_print(Request $request){
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
        $data['company'] = $data['config']->msyscompname;

        $query = DB::connection(Auth::user()->db_name)->table('mgoods')
        ->join('mcogs','mgoods.mgoodscode','=','mcogs.mcogsgoodscode');

        if($request->has('spl')){
            $query->where('mgoodssuppliercode',$request->spl);
            $data['spl'] = MSupplier::on(Auth::user()->db_name)->where('msupplierid',$request->spl)->first()->msuppliername;
        }

        if($request->has('goods')){
            $query->where('mgoodscode',$request->goods);
            $data['goods'] = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$request->goods)->first()->mgoodsname;
        }

        $stockvalues = $query->orderBy('mgoodscode','asc')->get();
        $data['total'] = 0;
        foreach($stockvalues as $st){
            $st->verbs = UnitHelper::label($st,$st->mgoodsstock);
            $data['total'] +=$st->mgoodsstock *$st->mcogslastcogs;
        }
        $data['stockvalues'] = $stockvalues;
        return view('admin.export.stockvalues',$data);
    }

    public function stockvalue_pdf(Request $request){
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
        $data['company'] = $data['config']->msyscompname;

        $query = DB::connection(Auth::user()->db_name)->table('mgoods')
        ->join('mcogs','mgoods.mgoodscode','=','mcogs.mcogsgoodscode');

        if($request->has('spl')){
            $query->where('mgoodssuppliercode',$request->spl);
            $data['spl'] = MSupplier::on(Auth::user()->db_name)->where('msupplierid',$request->spl)->first()->msuppliername;
        }

        if($request->has('goods')){
            $query->where('mgoodscode',$request->goods);
            $data['goods'] = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$request->goods)->first()->mgoodsname;
        }

        $stockvalues = $query->orderBy('mgoodscode','asc')->get();
        $data['total'] = 0;
        foreach($stockvalues as $st){
            $st->verbs = UnitHelper::label($st,$st->mgoodsstock);
            $data['total'] +=$st->mgoodsstock *$st->mcogslastcogs;
        }
        $data['stockvalues'] = $stockvalues;
        $pdf = PDF::loadview('admin/export/stockvalues',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Laporan Nilai Persediaan.pdf');
    }

    public function stockvalue_excel(Request $request){
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
        $this->data['company'] = $this->data['config']->msyscompname;

        $query = DB::connection(Auth::user()->db_name)->table('mgoods')
        ->join('mcogs','mgoods.mgoodscode','=','mcogs.mcogsgoodscode');

        if($request->has('spl')){
            $query->where('mgoodssuppliercode',$request->spl);
            $this->data['spl'] = MSupplier::on(Auth::user()->db_name)->where('msupplierid',$request->spl)->first()->msuppliername;
        }

        if($request->has('goods')){
            $query->where('mgoodscode',$request->goods);
            $this->data['goods'] = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$request->goods)->first()->mgoodsname;
        }

        $stockvalues = $query->orderBy('mgoodscode','asc')->get();
        $this->data['total'] = 0;
        foreach($stockvalues as $st){
            $st->verbs = UnitHelper::label($st,$st->mgoodsstock);
            $this->data['total'] +=$st->mgoodsstock *$st->mcogslastcogs;
        }
        $this->data['stockvalues'] = $stockvalues;
        $this->count = 0;
        return Excel::create('Laporan Nilai Persediaan',function($excel){
			$excel->sheet('Laporan Nilai Persediaan',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:E1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Laporan Nilai Persediaan'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

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

                $this->count++;
                $sheet->cell('A6',function($cell){
                    $cell->setValue('Barang');
                });
                $sheet->cell('B6',function($cell){
                    $cell->setValue($this->data['goods']);
                });

                $this->count++;
                $sheet->cell('A7',function($cell){
                    $cell->setValue('Gudang');
                });
                $sheet->cell('B7',function($cell){
                    $cell->setValue($this->data['wh']);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Barang','Nama Barang','Saldo Stock','Harga Beli','Nilai Persediaan'
                ));
                foreach($this->data['stockvalues'] as $sv){
                    $this->count++;
                    $sheet->row($this->count,array(
                        $sv->mgoodscode,
                        $sv->mgoodsname,
                        $sv->verbs,
                        $sv->mcogslastcogs,
                        $sv->mgoodsstock * $sv->mcogslastcogs,
                    ));
                }

                $this->count++;
                $sheet->row($this->count,array(
                    'TOTAL',
                    '',
                    '',
                    '',
                    $this->data['total'],
                ));

			});
		})->export('xls');

    }

    public function stockvalue_csv(Request $request){
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
        $this->data['company'] = $this->data['config']->msyscompname;

        $query = DB::connection(Auth::user()->db_name)->table('mgoods')
        ->join('mcogs','mgoods.mgoodscode','=','mcogs.mcogsgoodscode');

        if($request->has('spl')){
            $query->where('mgoodssuppliercode',$request->spl);
            $this->data['spl'] = MSupplier::on(Auth::user()->db_name)->where('msupplierid',$request->spl)->first()->msuppliername;
        }

        if($request->has('goods')){
            $query->where('mgoodscode',$request->goods);
            $this->data['goods'] = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$request->goods)->first()->mgoodsname;
        }

        $stockvalues = $query->orderBy('mgoodscode','asc')->get();
        $this->data['total'] = 0;
        foreach($stockvalues as $st){
            $st->verbs = UnitHelper::label($st,$st->mgoodsstock);
            $this->data['total'] +=$st->mgoodsstock *$st->mcogslastcogs;
        }
        $this->data['stockvalues'] = $stockvalues;
        $this->count = 0;
        return Excel::create('Laporan Nilai Persediaan',function($excel){
			$excel->sheet('Laporan Nilai Persediaan',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:E1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:E2');
                $sheet->row($this->count,array('Laporan Nilai Persediaan'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

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

                $this->count++;
                $sheet->cell('A6',function($cell){
                    $cell->setValue('Barang');
                });
                $sheet->cell('B6',function($cell){
                    $cell->setValue($this->data['goods']);
                });

                $this->count++;
                $sheet->cell('A7',function($cell){
                    $cell->setValue('Gudang');
                });
                $sheet->cell('B7',function($cell){
                    $cell->setValue($this->data['wh']);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Barang','Nama Barang','Saldo Stock','Harga Beli','Nilai Persediaan'
                ));
                foreach($this->data['stockvalues'] as $sv){
                    $this->count++;
                    $sheet->row($this->count,array(
                        $sv->mgoodscode,
                        $sv->mgoodsname,
                        $sv->verbs,
                        $sv->mcogslastcogs,
                        $sv->mgoodsstock * $sv->mcogslastcogs,
                    ));
                }

                $this->count++;
                $sheet->row($this->count,array(
                    'TOTAL',
                    '',
                    '',
                    '',
                    $this->data['total'],
                ));

			});
		})->export('csv');

    }
}
