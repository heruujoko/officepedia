<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Auth;
use App\MHInvoice;
use App\MDInvoice;
use App\MDPurchase;
use App\MConfig;
use App\Http\Requests;
use Excel;
use Carbon\Carbon;
use App\MARCard;
use App\MWarehouse;
use App\MCUSTOMER;
use App\MStockCard;
use App\Helper\UnitHelper;
use App\MGoods;
use App\MBRANCH;
use App\UserBranch;

class ReportController extends Controller
{

    private function salesreport_data($request){
        $sales = [];
        $headers=[];
        $mhinvoicesubtotal_sum = 0;
        $mhinvoicediscounttotal_sum = 0;
        $mhinvoicetaxtotal_sum = 0;
        $mhinvoicegrandtotal_sum = 0;
        $warehouse_ids = [];
        /*
         * filter date header
         */
        $header_query = MHInvoice::on(Auth::user()->db_name);
        if($request->has('start')){
            $header_query->whereDate('mhinvoicedate','>=',Carbon::parse($request->start));
        }
        if($request->has('end')){
            $header_query->whereDate('mhinvoicedate','<=',Carbon::parse($request->end));
        }

        if(!$request->has('wh')){
            // branch filter
            $branch_ids = UserBranch::on(Auth::user()->db_name)->where('userid',Auth::user()->id)->get();
            $branches = collect();
            foreach($branch_ids as $br){
                $br = MBRANCH::on(Auth::user()->db_name)->where('id',$br->branchid)->first();
                $branches->push($br);
            }

            foreach ($branches as $br) {
                $wh = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$br->mbranchcode)->get();
                foreach($wh as $w){
                    array_push($warehouse_ids,$w->id);
                }
            }
        }

        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)
                ->where('mdinvoicedate',$s->mhinvoicedate)
                ->where('mdinvoicegoodsid',$request->goods)
                ->where('mdinvoicegoodsidwhouse',$request->wh)
                ->get();
                $s['detail_count'] = count($details);
                $s['numoftrans'] = count($details);
                $s['header'] = true;
                foreach($details as $dt){

                        $mhinvoicesubtotal_sum += $dt->mdinvoicegoodsgrossamount;
                        $mhinvoicediscounttotal_sum += $dt->mdinvoicegoodsdiscount;
                        $mhinvoicetaxtotal_sum += $dt->mdinvoicegoodstax;
                        $mhinvoicegrandtotal_sum += ($dt->mdinvoicegoodsgrossamount + $dt->mdinvoicegoodstax);

                }

                $s['mhinvoicesubtotal_sum'] = $mhinvoicesubtotal_sum;
                $s['mhinvoicediscounttotal_sum'] = $mhinvoicediscounttotal_sum;
                $s['mhinvoicetaxtotal_sum'] = $mhinvoicetaxtotal_sum;
                $s['mhinvoicegrandtotal_sum'] = $mhinvoicegrandtotal_sum;
            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')->get();
            foreach($sales as $s){

                $mhinvoicesubtotal_sum = 0;
                $mhinvoicediscounttotal_sum = 0;
                $mhinvoicetaxtotal_sum = 0;
                $mhinvoicegrandtotal_sum = 0;

                $details = MDInvoice::on(Auth::user()->db_name)
                ->where('mdinvoicedate',$s->mhinvoicedate)
                ->where('mdinvoicegoodsidwhouse',$request->wh)
                ->get();
                $s['detail_count'] = count($details);
                $s['numoftrans'] = count($details);
                $s['header'] = true;
                foreach($details as $dt){

                        $mhinvoicesubtotal_sum += $dt->mdinvoicegoodsgrossamount;
                        $mhinvoicediscounttotal_sum += $dt->mdinvoicegoodsdiscount;
                        $mhinvoicetaxtotal_sum += $dt->mdinvoicegoodstax;
                        $mhinvoicegrandtotal_sum += ($dt->mdinvoicegoodsgrossamount + $dt->mdinvoicegoodstax);

                }

                $s['mhinvoicesubtotal_sum'] = $mhinvoicesubtotal_sum;
                $s['mhinvoicediscounttotal_sum'] = $mhinvoicediscounttotal_sum;
                $s['mhinvoicetaxtotal_sum'] = $mhinvoicetaxtotal_sum;
                $s['mhinvoicegrandtotal_sum'] = $mhinvoicegrandtotal_sum;

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)
            ->whereDate('mdinvoicedate','>=',Carbon::parse($request->start))
            ->whereDate('mdinvoicedate','<=',Carbon::parse($request->end))
            ->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')->get();
            foreach($sales as $s){
                $mhinvoicesubtotal_sum = 0;
                $mhinvoicediscounttotal_sum = 0;
                $mhinvoicetaxtotal_sum = 0;
                $mhinvoicegrandtotal_sum = 0;

                $details = MDInvoice::on(Auth::user()->db_name)
                ->where('mdinvoicedate',$s->mhinvoicedate)
                ->where('mdinvoicegoodsid',$request->goods)
                ->whereIn('mdinvoicegoodsidwhouse',$warehouse_ids)
                ->get();
                $s['detail_count'] = count($details);
                $s['numoftrans'] = count($details);
                $s['header'] = true;
                foreach($details as $dt){

                        $mhinvoicesubtotal_sum += $dt->mdinvoicegoodsgrossamount;
                        $mhinvoicediscounttotal_sum += $dt->mdinvoicegoodsdiscount;
                        $mhinvoicetaxtotal_sum += $dt->mdinvoicegoodstax;
                        $mhinvoicegrandtotal_sum += ($dt->mdinvoicegoodsgrossamount + $dt->mdinvoicegoodstax);

                }

                $s['mhinvoicesubtotal_sum'] = $mhinvoicesubtotal_sum;
                $s['mhinvoicediscounttotal_sum'] = $mhinvoicediscounttotal_sum;
                $s['mhinvoicetaxtotal_sum'] = $mhinvoicetaxtotal_sum;
                $s['mhinvoicegrandtotal_sum'] = $mhinvoicegrandtotal_sum;
            }
        } else {
            $sales = $header_query->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum,count(mhinvoiceno) as numoftrans')
            ->get();

            foreach($sales as $s){
                $details = MDInvoice::on(Auth::user()->db_name)->whereIn('mdinvoicegoodsidwhouse',$warehouse_ids)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);
                $s['numoftrans'] = count($details);
                $s['header'] = true;
            }
        }

        $expanded_ids = base64_decode($request->data);
        $expanded_ids = json_decode($expanded_ids);
        $sales = $sales->toArray();

        $expanded_sales = [];

        for($i = 0;$i<count($sales);$i++){
            $chunk = [];
            array_push($expanded_sales,$sales[$i]);
            if( in_array($sales[$i]['id'],$expanded_ids) ){
                $details = $this->sales_detail_data($request,$sales[$i]['mhinvoicedate']);
                foreach($details as $dt){
                    array_push($expanded_sales,$dt);
                }
            }
        }

        return json_encode($expanded_sales);
    }

    private function sales_detail_data($request,$invoice_date){
        $warehouse_ids = [];
        $detail_query = MDInvoice::on(Auth::user()->db_name)->whereDate('mdinvoicedate','=',Carbon::parse($invoice_date))->where('void',0)->orderBy('mhinvoiceno','asc');
        if($request->has('goods')){
            $detail_query->where('mdinvoicegoodsid',$request->goods);
        }
        if($request->has('wh')){
            $detail_query->where('mdinvoicegoodsidwhouse',$request->wh);
        } else {
            // branch filter
            $branch_ids = UserBranch::on(Auth::user()->db_name)->where('userid',Auth::user()->id)->get();
            $branches = collect();
            foreach($branch_ids as $br){
                $br = MBRANCH::on(Auth::user()->db_name)->where('id',$br->branchid)->first();
                $branches->push($br);
            }

            foreach ($branches as $br) {
                $wh = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$br->mbranchcode)->get();
                foreach($wh as $w){
                    array_push($warehouse_ids,$w->id);
                }
            }
            $detail_query->whereIn('mdinvoicegoodsidwhouse',$warehouse_ids);
        }
        $details = $detail_query->get();
        foreach ($details as $d) {
            $md = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$d->mhinvoiceno)->where('void',0)->get();
            $d['header'] = false;
            $d['numoftrans'] = count($md);
            $d['mhinvoicesubtotal_sum'] = $d->mdinvoicegoodsgrossamount;
            $d['mhinvoicetaxtotal_sum'] = $d->mdinvoicegoodstax;
            $d['mhinvoicegrandtotal_sum'] = $d->mdinvoicegoodsgrossamount + $d->mdinvoicegoodstax;
        }
        return $details;
    }

    public function salesreport(){

        if(Auth::user()->has_role('R_salesreport')){
            $data['config'] = MConfig::on(Auth::user()->db_name)->first();
            $data['active'] = 'salesreports';
            $data['section'] = 'Sales Report';
            return view('admin.salesreport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function salesreport_print(Request $request){

        // $data = $request->data;
        // $data = base64_decode($data);

        $decoded_data = json_decode($this->salesreport_data($request));

        if($request->wh != ''){
            $param['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $param['wh'] = "Semua";
        }

        if($request->goods != ''){
            $param['goods'] = $request->goods;
        } else {
            $param['goods'] = "Semua";
        }
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $param['decimals'] = $config->msysgenrounddec;
        $param['dec_point'] = $config->msysnumseparator;
        if($param['dec_point'] == ","){
          $param['thousands_sep'] = ".";
        } else {
          $param['thousands_sep'] = ",";
        }
        $param['sales'] = $decoded_data;
        $param['company'] = $config->msyscompname;
        $param['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $param['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $param['total_inv'] = 0;
        $param['total_sales'] = 0;
        $param['total_tax'] = 0;
        $param['total_grand'] = 0;
        foreach($decoded_data as $d){
            if($d->header == true){
                $param['total_inv'] += $d->numoftrans;
                $param['total_sales'] += $d->mhinvoicesubtotal_sum;
                $param['total_tax'] += $d->mhinvoicetaxtotal_sum;
                $param['total_grand'] += $d->mhinvoicegrandtotal_sum;
            }
        }

        return view('admin/export/salesreport',$param);
    }

    public function salesreport_pdf(Request $request){
        // $data = $request->data;
        // $data = base64_decode($data);

        $decoded_data = json_decode($this->salesreport_data($request));

        if($request->wh != ''){
            $param['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $param['wh'] = "Semua";
        }

        if($request->goods != ''){
            $param['goods'] = $request->goods;
        } else {
            $param['goods'] = "Semua";
        }
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $param['decimals'] = $config->msysgenrounddec;
        $param['dec_point'] = $config->msysnumseparator;
        if($param['dec_point'] == ","){
          $param['thousands_sep'] = ".";
        } else {
          $param['thousands_sep'] = ",";
        }
        $param['sales'] = $decoded_data;
        $param['company'] = $config->msyscompname;
        $param['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $param['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $param['total_inv'] = 0;
        $param['total_sales'] = 0;
        $param['total_tax'] = 0;
        $param['total_grand'] = 0;
        foreach($decoded_data as $d){
            if($d->header == true){
                $param['total_inv'] += $d->numoftrans;
                $param['total_sales'] += $d->mhinvoicesubtotal_sum;
                $param['total_tax'] += $d->mhinvoicetaxtotal_sum;
                $param['total_grand'] += $d->mhinvoicegrandtotal_sum;
            }
        }

        $pdf = PDF::loadview('admin/export/salesreport',$param);
		return $pdf->setPaper('a4', 'landscape')->download('Sales Report.pdf');
    }

    public function salesreport_excel(Request $request){
        $this->count =0;
        // $data_dec = $request->data;
        // $data_dec = base64_decode($data_dec);

        $decoded_data = json_decode($this->salesreport_data($request));
        if($request->wh != ''){
            $data['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $data['wh'] = "Semua";
        }

        if($request->goods != ''){
            $data['goods'] = $request->goods;
        } else {
            $data['goods'] = "Semua";
        }
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['sales'] = $decoded_data;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $data['total_inv'] = 0;
        $data['total_sales'] = 0;
        $data['total_tax'] = 0;
        $data['total_grand'] = 0;
        foreach($decoded_data as $d){
            if($d->header == true){
                $data['total_inv'] += $d->numoftrans;
                $data['total_sales'] += $d->mhinvoicesubtotal_sum;
                $data['total_tax'] += $d->mhinvoicetaxtotal_sum;
                $data['total_grand'] += $d->mhinvoicegrandtotal_sum;
            }
        }
        $this->data = $data;
        $this->sales = $decoded_data;
        $this->request = $request;
		return Excel::create('Sales Report',function($excel){
			$excel->sheet('Sales Report',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:K1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:K2');
                $sheet->row($this->count,array('Laporan Buku Penjualan'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:K3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Gudang');
                });
                $sheet->cell('B4',function($cell){
                    if($this->request->has('wh')){
                        $cell->setValue(MWarehouse::on(Auth::user()->db_name)->where('id',$this->request->wh)->first()->mwarehousename);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('N4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('O4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Barang');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('goods')){
                        $cell->setValue($this->request->goods);
                    } else {
                        $cell->setValue('Semua');
                    }
                });
                $sheet->cell('N5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('O5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Tgl Transaksi','Kode Customer','Customer','Jumlah Invoice','No Invoice','Kode Barang','Nama Barang','Quantity','Harga Satuan','Free Goods','Discount','Subtotal','PPN','Total','Keterangan'
                ));
                foreach($this->sales as $sl){
                    $this->count++;
                    if($sl->header == true){
                        $sheet->row($this->count,array(
                            $sl->mhinvoicedate,
                            '',
                            '',
                            $sl->numoftrans,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $sl->mhinvoicesubtotal_sum,
                            $sl->mhinvoicetaxtotal_sum,
                            $sl->mhinvoicegrandtotal_sum,
                            ''
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            $sl->mdcustomerid,
                            $sl->mdcustomername,
                            '',
                            $sl->mhinvoiceno,
                            $sl->mdinvoicegoodsid,
                            $sl->mdinvoicegoodsname,
                            $sl->mdinvoicegoodsqty,
                            $sl->mdinvoicegoodsprice,
                            '',
                            $sl->mdinvoicegoodsdiscount,
                            $sl->mhinvoicesubtotal_sum,
                            $sl->mhinvoicetaxtotal_sum,
                            $sl->mhinvoicegrandtotal_sum,
                            ''
                        ));
                    }

                }

                $this->count++;
                $sheet->row($this->count,array(
                    'Saldo',
                    '',
                    '',
                    $this->data['total_inv'],
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->data['total_sales'],
                    $this->data['total_tax'],
                    $this->data['total_grand'],
                ));

			});
		})->export('xls');
	}

    public function salesreport_csv(Request $request){
        $this->count =0;
        // $data_dec = $request->data;
        // $data_dec = base64_decode($data_dec);

        $decoded_data = json_decode($this->salesreport_data($request));
        if($request->wh != ''){
            $data['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $data['wh'] = "Semua";
        }

        if($request->goods != ''){
            $data['goods'] = $request->goods;
        } else {
            $data['goods'] = "Semua";
        }
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }
        $data['sales'] = $decoded_data;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $data['total_inv'] = 0;
        $data['total_sales'] = 0;
        $data['total_tax'] = 0;
        $data['total_grand'] = 0;
        foreach($decoded_data as $d){
            if($d->header == true){
                $data['total_inv'] += $d->numoftrans;
                $data['total_sales'] += $d->mhinvoicesubtotal_sum;
                $data['total_tax'] += $d->mhinvoicetaxtotal_sum;
                $data['total_grand'] += $d->mhinvoicegrandtotal_sum;
            }
        }
        $this->data = $data;
        $this->sales = $decoded_data;
        $this->request = $request;
		return Excel::create('Sales Report',function($excel){
			$excel->sheet('Sales Report',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:K1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:K2');
                $sheet->row($this->count,array('Laporan Buku Penjualan'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:K3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Gudang');
                });
                $sheet->cell('B4',function($cell){
                    if($this->request->has('wh')){
                        $cell->setValue(MWarehouse::on(Auth::user()->db_name)->where('id',$this->request->wh)->first()->mwarehousename);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('N4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('O4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Barang');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('goods')){
                        $cell->setValue($this->request->goods);
                    } else {
                        $cell->setValue('Semua');
                    }
                });
                $sheet->cell('N5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('O5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Tgl Transaksi','Kode Customer','Customer','Jumlah Invoice','No Invoice','Kode Barang','Nama Barang','Quantity','Harga Satuan','Free Goods','Discount','Subtotal','PPN','Total','Keterangan'
                ));
                foreach($this->sales as $sl){
                    $this->count++;
                    if($sl->header == true){
                        $sheet->row($this->count,array(
                            $sl->mhinvoicedate,
                            '',
                            '',
                            $sl->numoftrans,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $sl->mhinvoicesubtotal_sum,
                            $sl->mhinvoicetaxtotal_sum,
                            $sl->mhinvoicegrandtotal_sum,
                            ''
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            $sl->mdcustomerid,
                            $sl->mdcustomername,
                            '',
                            $sl->mhinvoiceno,
                            $sl->mdinvoicegoodsid,
                            $sl->mdinvoicegoodsname,
                            $sl->mdinvoicegoodsqty,
                            $sl->mdinvoicegoodsprice,
                            '',
                            $sl->mdinvoicegoodsdiscount,
                            $sl->mhinvoicesubtotal_sum,
                            $sl->mhinvoicetaxtotal_sum,
                            $sl->mhinvoicegrandtotal_sum,
                            ''
                        ));
                    }

                }

                $this->count++;
                $sheet->row($this->count,array(
                    'Saldo',
                    '',
                    '',
                    $this->data['total_inv'],
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->data['total_sales'],
                    $this->data['total_tax'],
                    $this->data['total_grand'],
                ));

			});
		})->export('csv');
	}

    public function invoicereport(){

        if(Auth::user()->has_role('R_salesinvoicereport')){
            $data['config'] = MConfig::on(Auth::user()->db_name)->first();
            $data['active'] = 'invoicereports';
            $data['section'] = 'Invoice Report';
            return view('admin.invoicereport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function invoicereport_print(Request $request){
        /*
         * price config
         */
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        /*
         * filterings
         */
        $queries = MDInvoice::on(Auth::user()->db_name)->where('void',0);
        if($request->has('start')){
             $queries->whereDate('mdinvoicedate','>=',Carbon::parse($request->start));
        }

        if($request->has('end')){
             $queries->whereDate('mdinvoicedate','<=',Carbon::parse($request->end));
        }
        if($request->has('goods') && $request->has('wh') != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
        } else if($request->has('goods') && $request->goods != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->where('void',0)->get();
        } else if($request->has('wh') && $request->wh != "" ){
            $invs = $queries->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
        } else {
            $invs = $queries->get();
        }
        $dates = [];
        foreach($invs as $i){
            array_push($dates,$i->mdinvoicedate);
        }
        $dates = array_unique($dates);
        $date_group_invoices = [];

        $discount_total = 0;
        $subtotal_total = 0;
        $tax_total = 0;

        foreach ($dates as $dt) {
            array_push($date_group_invoices,['date' => $dt,'data' => false]);
            /*
             * filterings
             */

            if($request->has('goods') && $request->has('wh') != ""){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
            } else if($request->has('goods') && $request->goods != ""){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('void',0)->get();
            } else if($request->has('wh') && $request->wh != "" ){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
            } else {
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('void',0)->get();
            }
            foreach ($inv as $iv) {
                $iv['data'] = true;
                $iv['price'] = number_format($iv->mdinvoicegoodsprice,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['disc'] = number_format($iv->mdinvoicegoodsdiscount,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['tax'] = number_format($iv->mdinvoicegoodstax,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['sub'] = number_format($iv->mdinvoicegoodsgrossamount ,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['total'] = number_format(($iv->mdinvoicegoodsgrossamount + $iv->mdinvoicegoodstax - $iv->mdinvoicegoodsdiscount) ,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                array_push($date_group_invoices,$iv);
                $discount_total += $iv->mdinvoicegoodsdiscount;
                $tax_total += $iv->mdinvoicegoodstax;
                $subtotal_total += $iv->mdinvoicegoodsgrossamount;
            }
        }

        $data['discount_total'] = $discount_total;
        $data['tax_total'] = $tax_total;
        $data['subtotal_total'] = $subtotal_total;
        $data['total_total'] = $subtotal_total + $tax_total - $discount_total;

        $data['invoices'] = $date_group_invoices;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('br')){
            $data['br'] = $request->br;
        } else {
            $data['br'] = "Semua";
        }
        if($request->has('wh')){
            $data['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $data['wh'] = "Semua";
        }
        if($request->has('goods')){
            $data['goods'] = $request->goods;
        } else {
            $data['goods'] = "Semua";
        }
        return view('admin.export.invoicereport',$data);

    }

    public function invoicereport_pdf(Request $request){
        /*
         * price config
         */
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        /*
         * filterings
         */
        $queries = MDInvoice::on(Auth::user()->db_name)->where('void',0);
        if($request->has('start')){
              $queries->whereDate('mdinvoicedate','>=',Carbon::parse($request->start));
        }

        if($request->has('end')){
              $queries->whereDate('mdinvoicedate','<=',Carbon::parse($request->end));
        }
        if($request->has('goods') && $request->has('wh') != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
        } else if($request->has('goods') && $request->goods != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->where('void',0)->get();
        } else if($request->has('wh') && $request->wh != "" ){
            $invs = $queries->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
        } else {
            $invs = $queries->get();
        }
        $dates = [];
        foreach($invs as $i){
            array_push($dates,$i->mdinvoicedate);
        }
        $dates = array_unique($dates);
        $date_group_invoices = [];
        $discount_total = 0;
        $subtotal_total = 0;
        $tax_total = 0;

        foreach ($dates as $dt) {
            array_push($date_group_invoices,['date' => $dt,'data' => false]);
            /*
             * filterings
             */

            if($request->has('goods') && $request->has('wh') != ""){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
            } else if($request->has('goods') && $request->goods != ""){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('void',0)->get();
            } else if($request->has('wh') && $request->wh != "" ){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
            } else {
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('void',0)->get();
            }
            foreach ($inv as $iv) {
                $iv['data'] = true;
                $iv['price'] = number_format($iv->mdinvoicegoodsprice,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['disc'] = number_format($iv->mdinvoicegoodsdiscount,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['tax'] = number_format($iv->mdinvoicegoodstax,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['sub'] = number_format($iv->mdinvoicegoodsgrossamount ,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $iv['total'] = number_format(($iv->mdinvoicegoodsgrossamount + $iv->mdinvoicegoodstax - $iv->mdinvoicegoodsdiscount) ,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                array_push($date_group_invoices,$iv);
                $discount_total += $iv->mdinvoicegoodsdiscount;
                $tax_total += $iv->mdinvoicegoodstax;
                $subtotal_total += $iv->mdinvoicegoodsgrossamount;
            }
        }

        $data['discount_total'] = number_format($discount_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['tax_total'] = number_format($tax_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['subtotal_total'] = number_format($subtotal_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['total_total'] = number_format($subtotal_total + $tax_total - $discount_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);

        $data['invoices'] = $date_group_invoices;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('br')){
            $data['br'] = $request->br;
        } else {
            $data['br'] = "Semua";
        }
        if($request->has('wh')){
            $data['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $data['wh'] = "Semua";
        }
        if($request->has('goods')){
            $data['goods'] = $request->goods;
        } else {
            $data['goods'] = "Semua";
        }
        $pdf = PDF::loadview('admin/export/invoicereport',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Invoice Report.pdf');
    }

    public function invoicereport_excel(Request $request){
        /*
         * price config
         */
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        /*
         * filterings
         */
        $queries = MDInvoice::on(Auth::user()->db_name)->where('void',0);
        if($request->has('start')){
               $queries->whereDate('mdinvoicedate','>=',Carbon::parse($request->start));
        }

        if($request->has('end')){
               $queries->whereDate('mdinvoicedate','<=',Carbon::parse($request->end));
        }
        if($request->has('goods') && $request->has('wh') != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
        } else if($request->has('goods') && $request->goods != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->get();
        } else if($request->has('wh') && $request->wh != "" ){
            $invs = $queries->where('mdinvoicegoodsidwhouse',$request->wh)->get();
        } else {
            $invs = $queries->get();
        }
        $dates = [];
        foreach($invs as $i){
            array_push($dates,$i->mdinvoicedate);
        }
        $dates = array_unique($dates);
        $date_group_invoices = [];
        $discount_total = 0;
        $subtotal_total = 0;
        $tax_total = 0;

        foreach ($dates as $dt) {
            array_push($date_group_invoices,['date' => $dt,'data' => false]);
            /*
             * filterings
             */

             if($request->has('goods') && $request->has('wh') != ""){
                 $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
             } else if($request->has('goods') && $request->goods != ""){
                 $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('void',0)->get();
             } else if($request->has('wh') && $request->wh != "" ){
                 $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
             } else {
                 $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('void',0)->get();
             }
            foreach ($inv as $iv) {
                $iv['data'] = true;
                $iv['price'] = $iv->mdinvoicegoodsprice;
                $iv['disc'] = $iv->mdinvoicegoodsdiscount;
                $iv['tax'] = $iv->mdinvoicegoodstax;
                $iv['sub'] = $iv->mdinvoicegoodsgrossamount ;
                $iv['total'] = ($iv->mdinvoicegoodsgrossamount + $iv->mdinvoicegoodstax - $iv->mdinvoicegoodsdiscount) ;
                array_push($date_group_invoices,$iv);
                $discount_total += $iv->mdinvoicegoodsdiscount;
                $tax_total += $iv->mdinvoicegoodstax;
                $subtotal_total += $iv->mdinvoicegoodsgrossamount;
            }
        }

        $this->discount_total = $discount_total;
        $this->tax_total = $tax_total;
        $this->subtotal_total = $subtotal_total;
        $this->total_total = $subtotal_total + $tax_total - $discount_total;

        $this->invoices = $date_group_invoices;

        $this->count = 0;
        $this->data['company'] = $config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $this->request = $request;
        return Excel::create('Invoice Report',function($excel){
            $excel->sheet('Invoice Report',function($sheet){
                $this->count++;
                $sheet->mergeCells('A1:L1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:L2');
                $sheet->row($this->count,array('Laporan Buku Penjualan Invoice'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:L3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=3;

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
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Gudang');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('wh')){
                        $cell->setValue(MWarehouse::on(Auth::user()->db_name)->where('id',$this->request->wh)->first()->mwarehousename);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('K5',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('L5',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A6',function($cell){
                    $cell->setValue('Barang');
                });
                $sheet->cell('B6',function($cell){
                    if($this->request->has('goods')){
                        $cell->setValue($this->request->goods);
                    } else {
                        $cell->setValue('Semua');
                    }
                });
                $sheet->cell('K6',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('L6',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Tgl Transaksi','No Invoice','Kode Barang','Nama Barang','Quantity','Harga Satuan','Free Goods','Discount','Subtotal','PPN','Total','Keterangan'
                ));
                foreach($this->invoices as $inv){
                    $this->count++;
                    if($inv['data'] == false){
                        $sheet->row($this->count,array(
                            $inv['date']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            $inv->mhinvoiceno,
                            $inv->mdinvoicegoodsid,
                            $inv->mdinvoicegoodsname,
                            $inv->mdinvoicegoodsqty,
                            $inv['price'],
                            '',
                            $inv['disc'],
                            $inv['sub'],
                            $inv['tax'],
                            $inv['total'],
                            "",
                        ));
                    }

                }
                $this->count++;
                $sheet->row($this->count,array(
                    'TOTAL',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->discount_total,
                    $this->subtotal_total,
                    $this->tax_total,
                    $this->total_total,
                    "",
                ));


            });
        })->export('xls');
    }

    public function invoicereport_csv(Request $request){
        /*
         * price config
         */
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        /*
         * filterings
         */
        $queries = MDInvoice::on(Auth::user()->db_name)->where('void',0);
        if($request->has('start')){
               $queries->whereDate('mdinvoicedate','>=',Carbon::parse($request->start));
        }

        if($request->has('end')){
               $queries->whereDate('mdinvoicedate','<=',Carbon::parse($request->end));
        }
        if($request->has('goods') && $request->has('wh') != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
        } else if($request->has('goods') && $request->goods != ""){
            $invs = $queries->where('mdinvoicegoodsid',$request->goods)->get();
        } else if($request->has('wh') && $request->wh != "" ){
            $invs = $queries->where('mdinvoicegoodsidwhouse',$request->wh)->get();
        } else {
            $invs = $queries->get();
        }
        $dates = [];
        foreach($invs as $i){
            array_push($dates,$i->mdinvoicedate);
        }
        $dates = array_unique($dates);
        $date_group_invoices = [];
        $discount_total = 0;
        $subtotal_total = 0;
        $tax_total = 0;

        foreach ($dates as $dt) {
            array_push($date_group_invoices,['date' => $dt,'data' => false]);
            /*
             * filterings
             */

            if($request->has('goods') && $request->has('wh') != ""){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
            } else if($request->has('goods') && $request->goods != ""){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsid',$request->goods)->where('void',0)->get();
            } else if($request->has('wh') && $request->wh != "" ){
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('mdinvoicegoodsidwhouse',$request->wh)->where('void',0)->get();
            } else {
                $inv = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$dt)->where('void',0)->get();
            }
            foreach ($inv as $iv) {
                $iv['data'] = true;
                $iv['price'] = $iv->mdinvoicegoodsprice;
                $iv['disc'] = $iv->mdinvoicegoodsdiscount;
                $iv['tax'] = $iv->mdinvoicegoodstax;
                $iv['sub'] = $iv->mdinvoicegoodsgrossamount ;
                $iv['total'] = ($iv->mdinvoicegoodsgrossamount + $iv->mdinvoicegoodstax - $iv->mdinvoicegoodsdiscount) ;
                array_push($date_group_invoices,$iv);
                $discount_total += $iv->mdinvoicegoodsdiscount;
                $tax_total += $iv->mdinvoicegoodstax;
                $subtotal_total += $iv->mdinvoicegoodsgrossamount;
            }
        }

        $this->discount_total = $discount_total;
        $this->tax_total = $tax_total;
        $this->subtotal_total = $subtotal_total;
        $this->total_total = $subtotal_total + $tax_total - $discount_total;

        $this->invoices = $date_group_invoices;
        $this->count = 0;
        $this->data['company'] = $config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $this->request = $request;
        return Excel::create('Invoice Report',function($excel){
            $excel->sheet('Invoice Report',function($sheet){
                $this->count++;
                $sheet->mergeCells('A1:L1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:L2');
                $sheet->row($this->count,array('Laporan Buku Penjualan Invoice'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:L3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=3;

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
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Gudang');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('wh')){
                        $cell->setValue(MWarehouse::on(Auth::user()->db_name)->where('id',$this->request->wh)->first()->mwarehousename);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('K5',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('L5',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A6',function($cell){
                    $cell->setValue('Barang');
                });
                $sheet->cell('B6',function($cell){
                    if($this->request->has('goods')){
                        $cell->setValue($this->request->goods);
                    } else {
                        $cell->setValue('Semua');
                    }
                });
                $sheet->cell('K6',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('L6',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Tgl Transaksi','No Invoice','Kode Barang','Nama Barang','Quantity','Harga Satuan','Free Goods','Discount','Subtotal','PPN','Total','Keterangan'
                ));
                foreach($this->invoices as $inv){
                    $this->count++;
                    if($inv['data'] == false){
                        $sheet->row($this->count,array(
                            $inv['date']
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            $inv->mhinvoiceno,
                            $inv->mdinvoicegoodsid,
                            $inv->mdinvoicegoodsname,
                            $inv->mdinvoicegoodsqty,
                            $inv['price'],
                            '',
                            $inv['disc'],
                            $inv['sub'],
                            $inv['tax'],
                            $inv['total'],
                            "",
                        ));
                    }

                }
                $this->count++;
                $sheet->row($this->count,array(
                    'TOTAL',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->discount_total,
                    $this->subtotal_total,
                    $this->tax_total,
                    $this->total_total,
                    "",
                ));


            });
        })->export('csv');
    }

    public function arreport(){

        if(Auth::user()->has_role('R_arreport')){
            $data['config'] = MConfig::on(Auth::user()->db_name)->first();
            $data['active'] = 'arreports';
            $data['section'] = 'Laporan Piutang';
            return view('admin.arreport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function arreport_print(Request $request){
        $queries = MARCard::on(Auth::user()->db_name);
        if($request->has('end')){
            $queries->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        if($request->has('cust')){
            $queries->where('marcardcustomerid',$request->cust);
        }

        // $ars = $queries->get();
        $ars = $queries->groupBy('marcardcustomerid')
        ->selectRaw('* , sum(marcardoutstanding) as marcardoutstanding_sum')
        ->get();

        /*
         * groupping ars
         */
         $marcardoutstanding_total = 0;
         $trans_count_total = 0;
         $seven_total = 0;
         $fourteen_total = 0;
         $twentyone_total = 0;
         $thirty_total = 0;
         $month_total = 0;

         foreach($ars as $ar){
             $marcardoutstanding_total += $ar->marcardoutstanding_sum;
             $now = Carbon::now();
             $due = Carbon::parse($ar->marcardduedate);
             $diff = $now->diffInDays($due,false);
             $ar['trans_count'] = count(MHInvoice::on(Auth::user()->db_name)->where('mhinvoicecustomerid',$ar->marcardcustomerid)->get());
             $trans_count_total += $ar['trans_count'];
             if($diff > 0){
                 if($diff <= 7){
                     $ar['seven'] = $ar->marcardoutstanding_sum;
                     $ar['fourteen'] =0;
                     $ar['twentyone'] =0;
                     $ar['thirty'] =0;
                     $ar['month'] =0;
                     $seven_total += $ar->marcardoutstanding_sum;
                 } else if($diff <= 14){
                     $ar['seven'] = 0;
                     $ar['fourteen'] = $ar->marcardoutstanding_sum;
                     $ar['twentyone'] =0;
                     $ar['thirty'] =0;
                     $ar['month'] =0;
                     $fourteen_total += $ar->marcardoutstanding_sum;
                 } else if($diff <= 21){
                     $ar['seven'] = 0;
                     $ar['fourteen'] =0;
                     $ar['twentyone'] = $ar->marcardoutstanding_sum;
                     $ar['thirty'] =0;
                     $ar['month'] =0;
                     $twentyone_total += $ar->marcardoutstanding_sum;
                 } else if($diff <= 30){
                     $ar['seven'] = 0;
                     $ar['fourteen'] =0;
                     $ar['twentyone'] =0;
                     $ar['thirty'] = $ar->marcardoutstanding_sum;
                     $ar['month'] =0;
                     $thirty_total += $ar->marcardoutstanding_sum;
                 } else {
                     $ar['seven'] = 0;
                     $ar['fourteen'] =0;
                     $ar['twentyone'] =0;
                     $ar['thirty'] =0;
                     $ar['month'] = $ar->marcardoutstanding_sum;
                     $month_total += $ar->marcardoutstanding_sum;
                 }
             } else {
                 $ar['seven'] = 0;
                 $ar['fourteen'] =0;
                 $ar['twentyone'] =0;
                 $ar['thirty'] =0;
                 $ar['month'] = 0;
                 $month_total += 0;
             }
         }

        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

        $data['marcardoutstanding_total'] = $marcardoutstanding_total;
        $data['seven_total'] = $seven_total;
        $data['fourteen_total'] = $fourteen_total;
        $data['twentyone_total'] = $twentyone_total;
        $data['thirty_total'] = $thirty_total;
        $data['month_total'] = $month_total;
        $data['trans_count_total'] = $trans_count_total;

        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['ars'] = $ars;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('br')){
            $data['br'] = $request->br;
        } else {
            $data['br'] = 'Semua';
        }
        if($request->has('cust')){
            $data['cust'] = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->cust)->first()->mcustomername;
        } else {
            $data['cust'] = 'Semua';
        }
        return view('admin/export/arreport',$data);
    }

    public function arreport_pdf(Request $request){
        $queries = MARCard::on(Auth::user()->db_name);
        if($request->has('end')){
            $queries->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        if($request->has('cust')){
            $queries->where('marcardcustomerid',$request->cust);
        }

        // $ars = $queries->get();
        $ars = $queries->groupBy('marcardcustomerid')
        ->selectRaw('* , sum(marcardoutstanding) as marcardoutstanding_sum')
        ->get();

        $marcardoutstanding_total = 0;
        $trans_count_total = 0;
        $seven_total = 0;
        $fourteen_total = 0;
        $twentyone_total = 0;
        $thirty_total = 0;
        $month_total = 0;

        foreach($ars as $ar){
            $marcardoutstanding_total += $ar->marcardoutstanding_sum;
            $now = Carbon::now();
            $due = Carbon::parse($ar->marcardduedate);
            $diff = $now->diffInDays($due,false);
            $ar['trans_count'] = count(MHInvoice::on(Auth::user()->db_name)->where('mhinvoicecustomerid',$ar->marcardcustomerid)->get());
            $trans_count_total += $ar['trans_count'];
            if($diff > 0){
                if($diff <= 7){
                    $ar['seven'] = $ar->marcardoutstanding_sum;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $seven_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 14){
                    $ar['seven'] = 0;
                    $ar['fourteen'] = $ar->marcardoutstanding_sum;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $fourteen_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 21){
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] = $ar->marcardoutstanding_sum;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $twentyone_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 30){
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] = $ar->marcardoutstanding_sum;
                    $ar['month'] =0;
                    $thirty_total += $ar->marcardoutstanding_sum;
                } else {
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] = $ar->marcardoutstanding_sum;
                    $month_total += $ar->marcardoutstanding_sum;
                }
            } else {
                $ar['seven'] = 0;
                $ar['fourteen'] =0;
                $ar['twentyone'] =0;
                $ar['thirty'] =0;
                $ar['month'] = 0;
                $month_total += 0;
            }
        }

       $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

       $data['marcardoutstanding_total'] = $marcardoutstanding_total;
       $data['seven_total'] = $seven_total;
       $data['fourteen_total'] = $fourteen_total;
       $data['twentyone_total'] = $twentyone_total;
       $data['thirty_total'] = $thirty_total;
       $data['month_total'] = $month_total;
       $data['trans_count_total'] = $trans_count_total;
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['ars'] = $ars;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('br')){
            $data['br'] = $request->br;
        } else {
            $data['br'] = 'Semua';
        }
        if($request->has('cust')){
            $data['cust'] = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->cust)->first()->mcustomername;
        } else {
            $data['cust'] = 'Semua';
        }
        $pdf = PDF::loadview('admin/export/arreport',$data);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf ->get_canvas();
        $canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
		return $pdf->setPaper('a4', 'potrait')->download('AR Report.pdf');
    }

    public function arreport_excel(Request $request){
        $queries = MARCard::on(Auth::user()->db_name);
        if($request->has('end')){
            $queries->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        if($request->has('cust')){
            $queries->where('marcardcustomerid',$request->cust);
        }

        // $ars = $queries->get();
        $ars = $queries->groupBy('marcardcustomerid')
        ->selectRaw('* , sum(marcardoutstanding) as marcardoutstanding_sum')
        ->get();

        $marcardoutstanding_total = 0;
        $trans_count_total = 0;
        $seven_total = 0;
        $fourteen_total = 0;
        $twentyone_total = 0;
        $thirty_total = 0;
        $month_total = 0;

        foreach($ars as $ar){
            $marcardoutstanding_total += $ar->marcardoutstanding_sum;
            $now = Carbon::now();
            $due = Carbon::parse($ar->marcardduedate);
            $diff = $now->diffInDays($due,false);
            $ar['trans_count'] = count(MHInvoice::on(Auth::user()->db_name)->where('mhinvoicecustomerid',$ar->marcardcustomerid)->get());
            $trans_count_total += $ar['trans_count'];
            if($diff > 0){
                if($diff <= 7){
                    $ar['seven'] = $ar->marcardoutstanding_sum;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $seven_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 14){
                    $ar['seven'] = 0;
                    $ar['fourteen'] = $ar->marcardoutstanding_sum;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $fourteen_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 21){
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] = $ar->marcardoutstanding_sum;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $twentyone_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 30){
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] = $ar->marcardoutstanding_sum;
                    $ar['month'] =0;
                    $thirty_total += $ar->marcardoutstanding_sum;
                } else {
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] = $ar->marcardoutstanding_sum;
                    $month_total += $ar->marcardoutstanding_sum;
                }
            } else {
                $ar['seven'] = 0;
                $ar['fourteen'] =0;
                $ar['twentyone'] =0;
                $ar['thirty'] =0;
                $ar['month'] = 0;
                $month_total += 0;
            }
        }

        $this->marcardoutstanding_total = $marcardoutstanding_total;
        $this->seven_total = $seven_total;
        $this->fourteen_total = $fourteen_total;
        $this->twentyone_total = $twentyone_total;
        $this->thirty_total = $thirty_total;
        $this->month_total = $month_total;
        $this->trans_count_total = $trans_count_total;

        $this->ars = $ars;
		$this->count = 0;
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $config->msysgenrounddec;
        $this->data['dec_point'] = $config->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['company'] = $config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $this->request = $request;
        return Excel::create('Ar Report',function($excel){
			$excel->sheet('Ar Report',function($sheet){
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
                $this->count++;
                $sheet->mergeCells('A3:K3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
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

                $sheet->cell('J4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('K4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Customer');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('cust')){
                        $cell->setValue(MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$this->request->cust)->first()->mcustomername);
                    } else {
                        $cell->setValue('Semua');
                    }
                });
                $sheet->cell('J5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('K5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=3;
                $sheet->mergeCells('E8:I8');
                $sheet->cell('E8',function($cell){
                    $cell->setValue('Outstanding');
                });
                $sheet->row($this->count,array(
                    'Kode Customer','Nama Customer','Total Nota','Outstanding','1-7 Hari','7-14 Hari','14-21 Hari','21 - 30 Hari','> 1 Bulan'
                ));

                foreach ($this->ars as $ar) {
                    $this->count++;
                    $sheet->row($this->count,array(
                        $ar->marcardcustomerid,
                        $ar->marcardcustomername,
                        $ar['trans_count'],
                        $ar->marcardoutstanding_sum,
                        $ar['seven'],
                        $ar['fourteen'],
                        $ar['twentyone'],
                        $ar['thirty'],
                        $ar['month']
                    ));
                }

                $this->count++;
                $sheet->row($this->count,array(
                    "TOTAL",
                    '',
                    $this->trans_count_total,
                    $this->marcardoutstanding_total,
                    $this->seven_total,
                    $this->fourteen_total,
                    $this->twentyone_total,
                    $this->thirty_total,
                    $this->month_total
                ));


			});
		})->export('xls');
    }

    public function arreport_csv(Request $request){
        $queries = MARCard::on(Auth::user()->db_name);
        if($request->has('end')){
            $queries->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        if($request->has('cust')){
            $queries->where('marcardcustomerid',$request->cust);
        }

        // $ars = $queries->get();
        $ars = $queries->groupBy('marcardcustomerid')
        ->selectRaw('* , sum(marcardoutstanding) as marcardoutstanding_sum')
        ->get();

        $marcardoutstanding_total = 0;
        $trans_count_total = 0;
        $seven_total = 0;
        $fourteen_total = 0;
        $twentyone_total = 0;
        $thirty_total = 0;
        $month_total = 0;

        foreach($ars as $ar){
            $marcardoutstanding_total += $ar->marcardoutstanding_sum;
            $now = Carbon::now();
            $due = Carbon::parse($ar->marcardduedate);
            $diff = $now->diffInDays($due,false);
            $ar['trans_count'] = count(MHInvoice::on(Auth::user()->db_name)->where('mhinvoicecustomerid',$ar->marcardcustomerid)->get());
            $trans_count_total += $ar['trans_count'];
            if($diff > 0){
                if($diff <= 7){
                    $ar['seven'] = $ar->marcardoutstanding_sum;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $seven_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 14){
                    $ar['seven'] = 0;
                    $ar['fourteen'] = $ar->marcardoutstanding_sum;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $fourteen_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 21){
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] = $ar->marcardoutstanding_sum;
                    $ar['thirty'] =0;
                    $ar['month'] =0;
                    $twentyone_total += $ar->marcardoutstanding_sum;
                } else if($diff <= 30){
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] = $ar->marcardoutstanding_sum;
                    $ar['month'] =0;
                    $thirty_total += $ar->marcardoutstanding_sum;
                } else {
                    $ar['seven'] = 0;
                    $ar['fourteen'] =0;
                    $ar['twentyone'] =0;
                    $ar['thirty'] =0;
                    $ar['month'] = $ar->marcardoutstanding_sum;
                    $month_total += $ar->marcardoutstanding_sum;
                }
            } else {
                $ar['seven'] = 0;
                $ar['fourteen'] =0;
                $ar['twentyone'] =0;
                $ar['thirty'] =0;
                $ar['month'] = 0;
                $month_total += 0;
            }
        }

        $this->marcardoutstanding_total = $marcardoutstanding_total;
        $this->seven_total = $seven_total;
        $this->fourteen_total = $fourteen_total;
        $this->twentyone_total = $twentyone_total;
        $this->thirty_total = $thirty_total;
        $this->month_total = $month_total;
        $this->trans_count_total = $trans_count_total;

        $this->ars = $ars;
		$this->count = 0;
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $config->msysgenrounddec;
        $this->data['dec_point'] = $config->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['company'] = $config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $this->request = $request;
        return Excel::create('Ar Report',function($excel){
			$excel->sheet('Ar Report',function($sheet){
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
                $this->count++;
                $sheet->mergeCells('A3:K3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
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

                $sheet->cell('J4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('K4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
                $sheet->cell('A5',function($cell){
                    $cell->setValue('Customer');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('cust')){
                        $cell->setValue(MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$this->request->cust)->first()->mcustomername);
                    } else {
                        $cell->setValue('Semua');
                    }
                });
                $sheet->cell('J5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('K5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=3;
                $sheet->mergeCells('E8:I8');
                $sheet->cell('E8',function($cell){
                    $cell->setValue('Outstanding');
                });
                $sheet->row($this->count,array(
                    'Kode Customer','Nama Customer','Total Nota','Outstanding','1-7 Hari','7-14 Hari','14-21 Hari','21 - 30 Hari','> 1 Bulan'
                ));

                foreach ($this->ars as $ar) {
                    $this->count++;
                    $sheet->row($this->count,array(
                        $ar->marcardcustomerid,
                        $ar->marcardcustomername,
                        $ar['trans_count'],
                        $ar->marcardoutstanding_sum,
                        $ar['seven'],
                        $ar['fourteen'],
                        $ar['twentyone'],
                        $ar['thirty'],
                        $ar['month']
                    ));
                }

                $this->count++;
                $sheet->row($this->count,array(
                    "TOTAL",
                    '',
                    $this->trans_count_total,
                    $this->marcardoutstanding_total,
                    $this->seven_total,
                    $this->fourteen_total,
                    $this->twentyone_total,
                    $this->thirty_total,
                    $this->month_total
                ));


			});
		})->export('csv');
    }

    public function arcustreport(){

        if(Auth::user()->has_role('R_arcustomerreport')){
            $data['config'] = MConfig::on(Auth::user()->db_name)->first();
            $data['active'] = 'arcustreport';
            $data['section'] = 'AR Customer Report';
            return view('admin.arcustreport',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function arcustreport_print(Request $request){
        $data_dec = $request->data;
        $data_dec = base64_decode($data_dec);

        $decoded_data = json_decode($data_dec);

        /*
         * price config
         */
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['thousands_sep'] = $config->msysnumseparator;
        if($data['thousands_sep'] == ","){
          $data['dec_point'] = ".";
        } else {
          $data['dec_point'] = ",";
        }

        $data['ars'] = $decoded_data;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $data['cust'] = $request->cust;

        if($request->has('cust')){
            $data['cust'] = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->cust)->first()->mcustomername;
        } else {
            $data['cust'] = "Semua";
        }
        if($request->has('br')){
            $data['br'] = $request->br;
        } else {
            $data['br'] = "Semua";
        }

        $data['total_inv'] = 0;
        $data['total_outs'] = 0;
        $data['total_1w'] = 0;
        $data['total_2w'] = 0;
        $data['total_3w'] = 0;
        $data['total_4w'] = 0;
        $data['total_1m'] = 0;

        foreach($decoded_data as $d){
            if($d->header == true){
                $data['total_inv'] += $d->marcardtotalinv;
                $data['total_outs'] += $d->marcardoutstanding;
                $data['total_1w'] += $d->{'1w'};
                $data['total_2w'] += $d->{'2w'};
                $data['total_3w'] += $d->{'3w'};
                $data['total_4w'] += $d->{'4w'};
                $data['total_1m'] += $d->{'1m'};
            }
        }

        return view('admin/export/arcustreport',$data);
    }

    public function arcustreport_pdf(Request $request){
        $data_dec = $request->data;
        $data_dec = base64_decode($data_dec);

        $decoded_data = json_decode($data_dec);

        /*
         * price config
         */
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['thousands_sep'] = $config->msysnumseparator;
        if($data['thousands_sep'] == ","){
          $data['dec_point'] = ".";
        } else {
          $data['dec_point'] = ",";
        }

        $data['ars'] = $decoded_data;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $data['cust'] = $request->cust;

        if($request->has('cust')){
            $data['cust'] = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->cust)->first()->mcustomername;
        } else {
            $data['cust'] = "Semua";
        }
        if($request->has('br')){
            $data['br'] = $request->br;
        } else {
            $data['br'] = "Semua";
        }

        $data['total_inv'] = 0;
        $data['total_outs'] = 0;
        $data['total_1w'] = 0;
        $data['total_2w'] = 0;
        $data['total_3w'] = 0;
        $data['total_4w'] = 0;
        $data['total_1m'] = 0;

        foreach($decoded_data as $d){
            if($d->header == true){
                $data['total_inv'] += $d->marcardtotalinv;
                $data['total_outs'] += $d->marcardoutstanding;
                $data['total_1w'] += $d->{'1w'};
                $data['total_2w'] += $d->{'2w'};
                $data['total_3w'] += $d->{'3w'};
                $data['total_4w'] += $d->{'4w'};
                $data['total_1m'] += $d->{'1m'};
            }
        }

        $pdf = PDF::loadview('admin/export/arcustreport',$data);
		return $pdf->setPaper('a4', 'landscape')->download('AR Customer Report.pdf');
    }

    public function arcustreport_excel(Request $request){

        $data_dec = $request->data;
        $data_dec = base64_decode($data_dec);

        $this->ars = json_decode($data_dec);
        /*
         * price config
         */
         $this->count = 0;
         $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
         $this->data['decimals'] = $config->msysgenrounddec;
         $this->data['thousands_sep'] = $config->msysnumseparator;
         if($this->data['thousands_sep'] == ","){
           $this->data['dec_point'] = ".";
         } else {
           $this->data['dec_point'] = ",";
         }
         $this->data['company'] = $config->msyscompname;
         $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
         $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');

        $this->request = $request;

        $this->data['total_inv'] = 0;
        $this->data['total_outs'] = 0;
        $this->data['total_1w'] = 0;
        $this->data['total_2w'] = 0;
        $this->data['total_3w'] = 0;
        $this->data['total_4w'] = 0;
        $this->data['total_1m'] = 0;

        foreach($this->ars as $d){
            if($d->header == true){
                $this->data['total_inv'] += $d->marcardtotalinv;
                $this->data['total_outs'] += $d->marcardoutstanding;
                $this->data['total_1w'] += $d->{'1w'};
                $this->data['total_2w'] += $d->{'2w'};
                $this->data['total_3w'] += $d->{'3w'};
                $this->data['total_4w'] += $d->{'4w'};
                $this->data['total_1m'] += $d->{'1m'};
            }
        }

        return Excel::create('Ar Customer Report',function($excel){
			$excel->sheet('Ar Customer Report',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:H1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:H2');
                $sheet->row($this->count,array('Laporan Buku Piutang Customer'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:H3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
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

                $sheet->cell('M4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('N4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;

                $sheet->cell('A5',function($cell){
                    $cell->setValue('Customer');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('cust')){
                        $cell->setValue(MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$this->request->cust)->first()->mcustomername);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('M5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('N5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Customer','Nama Customer','Total Nota','No Invoice','Nilai Invoice','Oustanding','Tgl Invoice','Tgl Jatuh Tempo','Aging','1-7 Hari','7-14 Hari','14-21 Hari','21-30 Hari','> 1 Bulan'
                ));

                foreach ($this->ars as $ar) {
                    $this->count++;
                    if($ar->header == true){
                        $sheet->row($this->count,array(
                            $ar->marcardcustomerid,
                            $ar->marcardcustomername,
                            $ar->numoftrans,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $ar->{'1w'},
                            $ar->{'2w'},
                            $ar->{'3w'},
                            $ar->{'4w'},
                            $ar->{'1m'}
                        ));
                    } else if($ar->data == true){
                        $sheet->row($this->count,array(
                            '',
                            '',
                            '',
                            $ar->marcardtransno,
                            $ar->marcardtotalinv,
                            $ar->marcardoutstanding,
                            $ar->marcarddate,
                            $ar->marcardduedate,
                            $ar->aging,
                            $ar->{'1w'},
                            $ar->{'2w'},
                            $ar->{'3w'},
                            $ar->{'4w'},
                            $ar->{'1m'}
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
                    'SALDO',
                    '',
                    '',
                    '',
                    $this->data['total_inv'],
                    $this->data['total_outs'],
                    '',
                    '',
                    '',
                    $this->data['total_1w'],
                    $this->data['total_2w'],
                    $this->data['total_3w'],
                    $this->data['total_4w'],
                    $this->data['total_1m']
                ));


			});
		})->export('xls');
    }

    public function arcustreport_csv(Request $request){

        $data_dec = $request->data;
        $data_dec = base64_decode($data_dec);

        $this->ars = json_decode($data_dec);
        /*
         * price config
         */
         $this->count = 0;
         $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
         $this->data['decimals'] = $config->msysgenrounddec;
         $this->data['thousands_sep'] = $config->msysnumseparator;
         if($this->data['thousands_sep'] == ","){
           $this->data['dec_point'] = ".";
         } else {
           $this->data['dec_point'] = ",";
         }
         $this->data['company'] = $config->msyscompname;
         $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
         $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');

        $this->request = $request;

        $this->data['total_inv'] = 0;
        $this->data['total_outs'] = 0;
        $this->data['total_1w'] = 0;
        $this->data['total_2w'] = 0;
        $this->data['total_3w'] = 0;
        $this->data['total_4w'] = 0;
        $this->data['total_1m'] = 0;

        foreach($this->ars as $d){
            if($d->header == true){
                $this->data['total_inv'] += $d->marcardtotalinv;
                $this->data['total_outs'] += $d->marcardoutstanding;
                $this->data['total_1w'] += $d->{'1w'};
                $this->data['total_2w'] += $d->{'2w'};
                $this->data['total_3w'] += $d->{'3w'};
                $this->data['total_4w'] += $d->{'4w'};
                $this->data['total_1m'] += $d->{'1m'};
            }
        }

        return Excel::create('Ar Customer Report',function($excel){
			$excel->sheet('Ar Customer Report',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:H1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:H2');
                $sheet->row($this->count,array('Laporan Buku Piutang Customer'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:H3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
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

                $sheet->cell('M4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('N4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;

                $sheet->cell('A5',function($cell){
                    $cell->setValue('Customer');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('cust')){
                        $cell->setValue(MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$this->request->cust)->first()->mcustomername);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('M5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('N5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Customer','Nama Customer','Total Nota','No Invoice','Nilai Invoice','Oustanding','Tgl Invoice','Tgl Jatuh Tempo','Aging','1-7 Hari','7-14 Hari','14-21 Hari','21-30 Hari','> 1 Bulan'
                ));

                foreach ($this->ars as $ar) {
                    $this->count++;
                    if($ar->header == true){
                        $sheet->row($this->count,array(
                            $ar->marcardcustomerid,
                            $ar->marcardcustomername,
                            $ar->numoftrans,
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            $ar->{'1w'},
                            $ar->{'2w'},
                            $ar->{'3w'},
                            $ar->{'4w'},
                            $ar->{'1m'}
                        ));
                    } else if($ar->data == true){
                        $sheet->row($this->count,array(
                            '',
                            '',
                            '',
                            $ar->marcardtransno,
                            $ar->marcardtotalinv,
                            $ar->marcardoutstanding,
                            $ar->marcarddate,
                            $ar->marcardduedate,
                            $ar->aging,
                            $ar->{'1w'},
                            $ar->{'2w'},
                            $ar->{'3w'},
                            $ar->{'4w'},
                            $ar->{'1m'}
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
                    'SALDO',
                    '',
                    '',
                    '',
                    $this->data['total_inv'],
                    $this->data['total_outs'],
                    '',
                    '',
                    '',
                    $this->data['total_1w'],
                    $this->data['total_2w'],
                    $this->data['total_3w'],
                    $this->data['total_4w'],
                    $this->data['total_1m']
                ));


			});
		})->export('csv');
    }

    private function stockreport_data($request){

        $query = MStockCard::on(Auth::user()->db_name);
        if ($request->has('start')) {
             $query->whereDate('mstockcarddate','>=',Carbon::parse($request->start));
        }
        if($request->has('end')){
                $query->whereDate('mstockcarddate','<=',Carbon::parse($request->end));
            }
        if($request->has('mstockcardgoodsid')){
                $query->where('mstockcardgoodsid',$request->mstockcardgoodsid);
        }
        if ($request->has('mstockcardwhouse')) {
            $query->where('mstockcardwhouse',$request->mstockcardwhouse);
        }

        // branch filter
        $branch_ids = UserBranch::on(Auth::user()->db_name)->where('userid',Auth::user()->id)->get();
        $branches = collect();
        foreach($branch_ids as $br){
            $br = MBRANCH::on(Auth::user()->db_name)->where('id',$br->branchid)->first();
            $branches->push($br);
        }

        $warehouse_ids = [];
        foreach ($branches as $br) {
            $wh = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$br->mbranchcode)->get();
            foreach($wh as $w){
                array_push($warehouse_ids,$w->id);
            }
        }

        $data = $query->whereIn('mstockcardwhouse',$warehouse_ids)->groupBy('mstockcardgoodsid')->get();

        $headers = [];
        $stocks =[];

        foreach($data as $dt){
            array_push($headers,array('mstockcardgoodsid' => $dt->mstockcardgoodsid,'mstockcardgoodsname' => $dt->mstockcardgoodsname));
        }

        foreach ($headers as $dtl) {
            $grp_h = array(
                'blank' => false,
                'data' => 'header',
                'footer' => false,
                'mstockcardgoodsid' => $dtl['mstockcardgoodsid'],
                'mstockcardgoodsname' => $dtl['mstockcardgoodsname'],
            );
            array_push($stocks,$grp_h);
            $grp_query = MStockCard::on(Auth::user()->db_name)->where('mstockcardgoodsid',$dtl['mstockcardgoodsid']);

            if ($request->has('start')) {
                 $grp_query->whereDate('mstockcarddate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                    $grp_query->whereDate('mstockcarddate','<=',Carbon::parse($request->end));
            }
            if ($request->has('mstockcardwhouse')) {
                $grp_query->where('mstockcardwhouse',$request->mstockcardwhouse);
            }

            $grp = $grp_query->get();
            foreach ($grp as $g) {

                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g->mstockcardgoodsid)->first();

                $g['data'] = 'data';
                $g['blank'] = false;
                $g['footer'] = false;
                if($g->mstockcardstockin != 0){
                    $g['verbs'] = UnitHelper::label($mgoods,$g->mstockcardstockin);
                } else {
                    $g['verbs'] = UnitHelper::label($mgoods,$g->mstockcardstockout);
                }

                $g['gudang'] = $g->gudang()->mwarehousename;
                $g['cabang'] = $g->gudang()->cabang()->mbranchname;
                $g['single'] = UnitHelper::singlelabel($mgoods,$g->mstockcardstocktotal);
                array_push($stocks,$g);
            }

            $last_stock = end($stocks);

            $blank = array(
                'blank' => true,
                'data' => 'blank',
                'footer' => false
            );

            $footer = array(
                'data' => false,
                'blank' => false,
                'footer' => true,
                'mstockcardgoodsid' => $last_stock['mstockcardgoodsid'],
                'mstockcardgoodsname' => $last_stock->mstockcardgoodsname,
                'mstockcardstocktotal' => $last_stock->mstockcardstocktotal,
                'mstockcardstockin' => $last_stock->mstockcardstockin,
                'mstockcardstockout' => $last_stock->mstockcardstockout,
                'verbs' => UnitHelper::label($mgoods,$last_stock->mstockcardstocktotal),
                'mstockcarddate' => $last_stock->mstockcarddate,
                'mstockcardtranstype' => $last_stock->mstockcardtranstype,
                'mstockcardtransno' => $last_stock->mstockcardtransno,
                'gudang' => $last_stock['gudang'],
                'mstockcardremark' => $last_stock->mstockcardremark
            );

            $footer['footer'] = true;
            $footer['data'] = 'footer';
            array_push($stocks,$footer);
            array_push($stocks,$blank);

        }

        return $stocks;

    }

    public function stockreport_print(Request $request){

        $data['stocks'] = $this->stockreport_data($request);
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('wh')){
            $data['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $data['wh'] = 'Semua';
        }
        if($request->has('goods')){
            $data['goods'] = $request->goods;
        } else {
            $data['goods'] = 'Semua';
        }
        $data['decimals'] = $config->msysgenrounddec;
        $data['thousands_sep'] = $config->msysnumseparator;
        if($data['thousands_sep'] == ","){
          $data['dec_point'] = ".";
        } else {
          $data['dec_point'] = ",";
        }
        return view('admin.export.stockreport',$data);
    }

    public function stockreport_pdf(Request $request){
        $data['stocks'] = $this->stockreport_data($request);
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('wh')){
            $data['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $data['wh'] = 'Semua';
        }
        if($request->has('goods')){
            $data['goods'] = $request->goods;
        } else {
            $data['goods'] = 'Semua';
        }
        $pdf = PDF::loadview('admin/export/stockreport',$data);
		return $pdf->setPaper('a4', 'landscape')->download('Stock Card Report.pdf');
    }

    public function stockreport_excel(Request $request){
        $this->data['stocks'] = $this->stockreport_data($request);
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['company'] = $config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('wh')){
            $this->data['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $this->data['wh'] = 'Semua';
        }
        if($request->has('goods')){
            $this->data['goods'] = $request->goods;
        } else {
            $this->data['goods'] = 'Semua';
        }

        $this->count = 0;
        $this->request = $request;
        return Excel::create('Stock Report',function($excel){
			$excel->sheet('Stock Report',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:M1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:M2');
                $sheet->row($this->count,array('Laporan Stock'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:M3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Gudang');
                });
                $sheet->cell('B4',function($cell){
                    if($this->request->has('wh')){
                        $cell->setValue($this->data['wh']);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('L4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('M4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;

                $sheet->cell('A5',function($cell){
                    $cell->setValue('Barang');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('goods')){
                        $cell->setValue($this->data['goods']);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('L5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('M5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Barang','Nama Barang','Multi Satuan','Masuk','Keluar','Saldo','Tgl Trans','Tipe Trans','No Trans','Gudang','Cabang','Keterangan'
                ));

                foreach ($this->data['stocks'] as $st) {
                    $this->count++;
                    if($st['data'] == 'header'){
                        $sheet->row($this->count,array(
                            $st['mstockcardgoodsid'],
                            $st['mstockcardgoodsname'],
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Umum',
                            ''
                        ));
                    } else if($st['data'] == 'data'){
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $st['verbs'],
                            $st->mstockcardstockin,
                            $st->mstockcardstockout,
                            ($st->mstockcardstocktotal),
                            $st->mstockcarddate,
                            $st->mstockcardtranstype,
                            $st->mstockcardtransno,
                            $st['gudang'],
                            'Umum',
                            ''
                        ));
                    } else if($st['data'] == 'footer'){
                        $sheet->row($this->count,array(
                            'Saldo',
                            '',
                            $st['verbs'],
                            $st['mstockcardstockin'],
                            $st['mstockcardstockout'],
                            ($st['mstockcardstocktotal']),
                            '',
                            '',
                            '',
                            '',
                            '',
                            ''
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
                            '',
                            '',
                            '',
                            ''
                        ));
                    }
                }


			});
		})->export('xls');
    }

    public function stockreport_csv(Request $request){

        $this->data['stocks'] = $this->stockreport_data($request);
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['company'] = $config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('wh')){
            $this->data['wh'] = MWarehouse::on(Auth::user()->db_name)->where('id',$request->wh)->first()->mwarehousename;
        } else {
            $this->data['wh'] = 'Semua';
        }
        if($request->has('goods')){
            $this->data['goods'] = $request->goods;
        } else {
            $this->data['goods'] = 'Semua';
        }

        $this->count = 0;
        $this->request = $request;
        return Excel::create('Stock Report',function($excel){
			$excel->sheet('Stock Report',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:M1');
                $sheet->row($this->count,array($this->data['company']));
                $sheet->cell('A1',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A2:M2');
                $sheet->row($this->count,array('Laporan Stock'));
                $sheet->cell('A2',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count++;
                $sheet->mergeCells('A3:M3');
                $sheet->row($this->count,array('Periode '.$this->data['start'].' - '.$this->data['end']));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('A4',function($cell){
                    $cell->setValue('Gudang');
                });
                $sheet->cell('B4',function($cell){
                    if($this->request->has('wh')){
                        $cell->setValue($this->data['wh']);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('L4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('M4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;

                $sheet->cell('A5',function($cell){
                    $cell->setValue('Barang');
                });
                $sheet->cell('B5',function($cell){
                    if($this->request->has('goods')){
                        $cell->setValue($this->data['goods']);
                    } else {
                        $cell->setValue('Semua');
                    }
                });

                $sheet->cell('L5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('M5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Barang','Nama Barang','Multi Satuan','Masuk','Keluar','Saldo','Tgl Trans','Tipe Trans','No Trans','Gudang','Cabang','Keterangan'
                ));

                foreach ($this->data['stocks'] as $st) {
                    $this->count++;
                    if($st['data'] == 'header'){
                        $sheet->row($this->count,array(
                            $st['mstockcardgoodsid'],
                            $st['mstockcardgoodsname'],
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Umum',
                            ''
                        ));
                    } else if($st['data'] == 'data'){
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $st['verbs'],
                            $st->mstockcardstockin,
                            $st->mstockcardstockout,
                            ($st->mstockcardstocktotal),
                            $st->mstockcarddate,
                            $st->mstockcardtranstype,
                            $st->mstockcardtransno,
                            $st['gudang'],
                            'Umum',
                            ''
                        ));
                    } else if($st['data'] == 'footer'){
                        $sheet->row($this->count,array(
                            'Saldo',
                            '',
                            $st['verbs'],
                            $st['mstockcardstockin'],
                            $st['mstockcardstockout'],
                            ($st['mstockcardstocktotal']),
                            '',
                            '',
                            '',
                            '',
                            '',
                            ''
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
                            '',
                            '',
                            '',
                            ''
                        ));
                    }
                }


			});
		})->export('csv');
    }
}
