<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use App\MHPurchase;
use App\MDPurchase;
use Auth;
use PDF;
use Excel;
use Carbon\Carbon;

class PurchaseReportController extends Controller
{
    public function purchasereport(){
        $data['active'] = 'purchasereport';
        $data['section'] = 'Laporan Pembelian';
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.purchasereport',$data);
    }

    public function purchasereport_print(Request $request){

        $query = MDPurchase::on(Auth::user()->db_name)->where('void',0);

        if($request->has('wh')){
            $query->where('mdpurchasegoodsidwhouse',$request->wh);
        }

        if($request->has('goods')){
            $query->where('mdpurchasegoodsid',$request->goods);
        }

        if($request->has('end')){
            $query->whereDate('mdpurchasedate','<=',Carbon::parse($request->end));
        }

        if($request->has('start')){
            $query->whereDate('mdpurchasedate','>=',Carbon::parse($request->start));
        }

        if($request->has('spl')){
            $query->where('mdpurchasesupplierid',$request->spl);
        }

        $purchase_group = $query->groupBy('mdpurchasedate')->get();
        $purchase_dates = [];
        foreach($purchase_group as $grp){
            array_push($purchase_dates,$grp->mdpurchasedate);
        }

        $purchases = [];
        foreach ($purchase_dates as $dates) {
            $header = array(
                'data' => false,
                'mdpurchasedate' => $dates
            );
            array_push($purchases,$header);
            $grp_q = MDPurchase::on(Auth::user()->db_name)->where('mdpurchasedate',$dates)->where('void',0);

            if($request->has('wh')){
                $grp_q->where('mdpurchasegoodsidwhouse',$request->wh);
            }

            if($request->has('goods')){
                $grp_q->where('mdpurchasegoodsid',$request->goods);
            }

            if($request->has('spl')){
                $grp_q->where('mdpurchasesupplierid',$request->spl);
            }

            $grp_data = $grp_q->get();

            foreach($grp_data as $d){
                $d['data'] = true;
                array_push($purchases,$d);
            }
        }

        $data['purchases'] = $purchases;
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
        $data['start'] = $request->start;
        $data['end'] = $request->end;
        return view('admin.export.purchasereport',$data);
    }

    public function purchasereport_pdf(Request $request){

        $query = MDPurchase::on(Auth::user()->db_name)->where('void',0);

        if($request->has('wh')){
            $query->where('mdpurchasegoodsidwhouse',$request->wh);
        }

        if($request->has('goods')){
            $query->where('mdpurchasegoodsid',$request->goods);
        }

        if($request->has('end')){
            $query->whereDate('mdpurchasedate','<=',Carbon::parse($request->end));
        }

        if($request->has('start')){
            $query->whereDate('mdpurchasedate','>=',Carbon::parse($request->start));
        }

        if($request->has('spl')){
            $query->where('mdpurchasesupplierid',$request->spl);
        }

        $purchase_group = $query->groupBy('mdpurchasedate')->get();
        $purchase_dates = [];
        foreach($purchase_group as $grp){
            array_push($purchase_dates,$grp->mdpurchasedate);
        }

        $purchases = [];
        foreach ($purchase_dates as $dates) {
            $header = array(
                'data' => false,
                'mdpurchasedate' => $dates
            );
            array_push($purchases,$header);
            $grp_q = MDPurchase::on(Auth::user()->db_name)->where('mdpurchasedate',$dates)->where('void',0);

            if($request->has('wh')){
                $grp_q->where('mdpurchasegoodsidwhouse',$request->wh);
            }

            if($request->has('goods')){
                $grp_q->where('mdpurchasegoodsid',$request->goods);
            }

            if($request->has('spl')){
                $grp_q->where('mdpurchasesupplierid',$request->spl);
            }

            $grp_data = $grp_q->get();

            foreach($grp_data as $d){
                $d['data'] = true;
                array_push($purchases,$d);
            }
        }

        $data['purchases'] = $purchases;
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
        $data['start'] = $request->start;
        $data['end'] = $request->end;

        $pdf = PDF::loadview('admin/export/purchasereport',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Laporan Pembelian.pdf');
    }

    public function purchasereport_excel(Request $request){
        $query = MDPurchase::on(Auth::user()->db_name)->where('void',0);

        if($request->has('wh')){
            $query->where('mdpurchasegoodsidwhouse',$request->wh);
        }

        if($request->has('goods')){
            $query->where('mdpurchasegoodsid',$request->goods);
        }

        if($request->has('end')){
            $query->whereDate('mdpurchasedate','<=',Carbon::parse($request->end));
        }

        if($request->has('start')){
            $query->whereDate('mdpurchasedate','>=',Carbon::parse($request->start));
        }

        if($request->has('spl')){
            $query->where('mdpurchasesupplierid',$request->spl);
        }

        $purchase_group = $query->groupBy('mdpurchasedate')->get();
        $purchase_dates = [];
        foreach($purchase_group as $grp){
            array_push($purchase_dates,$grp->mdpurchasedate);
        }

        $purchases = [];
        foreach ($purchase_dates as $dates) {
            $header = array(
                'data' => false,
                'mdpurchasedate' => $dates
            );
            array_push($purchases,$header);
            $grp_q = MDPurchase::on(Auth::user()->db_name)->where('mdpurchasedate',$dates)->where('void',0);

            if($request->has('wh')){
                $grp_q->where('mdpurchasegoodsidwhouse',$request->wh);
            }

            if($request->has('goods')){
                $grp_q->where('mdpurchasegoodsid',$request->goods);
            }

            if($request->has('spl')){
                $grp_q->where('mdpurchasesupplierid',$request->spl);
            }

            $grp_data = $grp_q->get();

            foreach($grp_data as $d){
                $d['data'] = true;
                array_push($purchases,$d);
            }
        }

        $this->data['purchases'] = $purchases;
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
        $this->data['start'] = $request->start;
        $this->data['end'] = $request->end;
        $this->count = 0;
        return Excel::create('Laporan Pembelian',function($excel){
			$excel->sheet('Laporan Pembelian',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:L1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:L2');
                $sheet->row($this->count,array('Laporan Nilai Persediaan'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count++;
                $sheet->mergeCells('A3:L3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count+=2;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Cabang');
                });
                $sheet->cell('B4',function($cell){
                    $cell->setValue('Semua');
                });

                $sheet->cell('K4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('L4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Supplier');
                });
                $sheet->cell('B5',function($cell){
                    $cell->setValue($this->data['spl']);
                });
                $sheet->cell('K5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('L5',function($cell){
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
                    'Tgl Transaksi','No Pembelian','Pembelian Dari','Kode Barang','Qty','Harga Satuan','Free Goods','Discount','Subtotal','PPn','Total','Keterangan'
                ));
                foreach($this->data['purchases'] as $sv){
                    $this->count++;
                    if($sv['data'] == false){
                        $sheet->row($this->count,array(
                            $sv['mdpurchasedate']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            $sv->mhpurchaseno,
                            $sv->mdpurchasesuppliername,
                            $sv->mdpurchasegoodsid,
                            $sv->mdpurchasegoodsqty,
                            $sv->mdpurchasebuyprice,
                            '-',
                            $sv->mdpurchasegoodsdiscount,
                            ($sv->mdpurchasegoodsgrossamount + $sv->mdpurchasegoodsdiscount),
                            $sv->mdpurchasetax,
                            ($sv->mdpurchasegoodsgrossamount + $sv->mdpurchasetax),
                            ''
                        ));
                    }

                }

			});
		})->export('xls');
    }

    public function purchasereport_csv(Request $request){
        $query = MDPurchase::on(Auth::user()->db_name)->where('void',0);

        if($request->has('wh')){
            $query->where('mdpurchasegoodsidwhouse',$request->wh);
        }

        if($request->has('goods')){
            $query->where('mdpurchasegoodsid',$request->goods);
        }

        if($request->has('end')){
            $query->whereDate('mdpurchasedate','<=',Carbon::parse($request->end));
        }

        if($request->has('start')){
            $query->whereDate('mdpurchasedate','>=',Carbon::parse($request->start));
        }

        if($request->has('spl')){
            $query->where('mdpurchasesupplierid',$request->spl);
        }

        $purchase_group = $query->groupBy('mdpurchasedate')->get();
        $purchase_dates = [];
        foreach($purchase_group as $grp){
            array_push($purchase_dates,$grp->mdpurchasedate);
        }

        $purchases = [];
        foreach ($purchase_dates as $dates) {
            $header = array(
                'data' => false,
                'mdpurchasedate' => $dates
            );
            array_push($purchases,$header);
            $grp_q = MDPurchase::on(Auth::user()->db_name)->where('mdpurchasedate',$dates)->where('void',0);

            if($request->has('wh')){
                $grp_q->where('mdpurchasegoodsidwhouse',$request->wh);
            }

            if($request->has('goods')){
                $grp_q->where('mdpurchasegoodsid',$request->goods);
            }

            if($request->has('spl')){
                $grp_q->where('mdpurchasesupplierid',$request->spl);
            }

            $grp_data = $grp_q->get();

            foreach($grp_data as $d){
                $d['data'] = true;
                array_push($purchases,$d);
            }
        }

        $this->data['purchases'] = $purchases;
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
        $this->data['start'] = $request->start;
        $this->data['end'] = $request->end;
        $this->count = 0;
        return Excel::create('Laporan Pembelian',function($excel){
            $excel->sheet('Laporan Pembelian',function($sheet){
                $this->count++;
                $sheet->mergeCells('A1:L1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:L2');
                $sheet->row($this->count,array('Laporan Nilai Persediaan'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count++;
                $sheet->mergeCells('A3:L3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });

                $this->count+=2;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Cabang');
                });
                $sheet->cell('B4',function($cell){
                    $cell->setValue('Semua');
                });

                $sheet->cell('K4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('L4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Supplier');
                });
                $sheet->cell('B5',function($cell){
                    $cell->setValue($this->data['spl']);
                });
                $sheet->cell('K5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('L5',function($cell){
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
                    'Tgl Transaksi','No Pembelian','Pembelian Dari','Kode Barang','Qty','Harga Satuan','Free Goods','Discount','Subtotal','PPn','Total','Keterangan'
                ));
                foreach($this->data['purchases'] as $sv){
                    $this->count++;
                    if($sv['data'] == false){
                        $sheet->row($this->count,array(
                            $sv['mdpurchasedate']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            $sv->mhpurchaseno,
                            $sv->mdpurchasesuppliername,
                            $sv->mdpurchasegoodsid,
                            $sv->mdpurchasegoodsqty,
                            $sv->mdpurchasebuyprice,
                            '-',
                            $sv->mdpurchasegoodsdiscount,
                            ($sv->mdpurchasegoodsgrossamount + $sv->mdpurchasegoodsdiscount),
                            $sv->mdpurchasetax,
                            ($sv->mdpurchasegoodsgrossamount + $sv->mdpurchasetax),
                            ''
                        ));
                    }

                }

            });
        })->export('csv');
    }
}
