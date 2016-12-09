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

class ReportController extends Controller
{
    public function salesreport(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'salesreports';
        $data['section'] = 'Sales Report';
        return view('admin.salesreport',$data);
    }

    public function salesreport_print(Request $request){

        $sales = [];
        $headers=[];

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

        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = $header_query->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }

        $invoice_count =0;
        $sales_total =0;
        $discount_total =0;
        $tax_total =0;
        $grandtotal_total =0;
        foreach ($sales as $sl) {
            $invoice_count += $sl['detail_count'];
            $sales_total += $sl->mhinvoicesubtotal_sum;
            $discount_total += $sl->mhinvoicediscounttotal_sum;
            $tax_total += $sl->mhinvoicetaxtotal_sum;
            $grandtotal_total += $sl->mhinvoicegrandtotal_sum;
        }

        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['invoice_count_total'] = number_format($invoice_count,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['sales_total'] = number_format($sales_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['discount_total'] = number_format($discount_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['tax_total'] = number_format($tax_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['grandtotal_total'] = number_format($grandtotal_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);

        $data['sales'] = $sales;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
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

        return view('admin/export/salesreport',$data);
    }

    public function salesreport_pdf(Request $request){
        $sales = [];
        $headers=[];

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

        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = $header_query->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }

        $invoice_count =0;
        $sales_total =0;
        $discount_total =0;
        $tax_total =0;
        $grandtotal_total =0;
        foreach ($sales as $sl) {
            $invoice_count += $sl['detail_count'];
            $sales_total += $sl->mhinvoicesubtotal_sum;
            $discount_total += $sl->mhinvoicediscounttotal_sum;
            $tax_total += $sl->mhinvoicetaxtotal_sum;
            $grandtotal_total += $sl->mhinvoicegrandtotal_sum;
        }

        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['invoice_count_total'] = number_format($invoice_count,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['sales_total'] = number_format($sales_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['discount_total'] = number_format($discount_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['tax_total'] = number_format($tax_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
        $data['grandtotal_total'] = number_format($grandtotal_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);

        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['sales'] = $sales;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
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
        $pdf = PDF::loadview('admin/export/salesreport',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Sales Report.pdf');
    }

    public function salesreport_excel(Request $request){

        $sales = [];
        $headers=[];

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

        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = $header_query->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }

        $this->invoice_count =0;
        $this->sales_total =0;
        $this->discount_total =0;
        $this->tax_total =0;
        $this->grandtotal_total =0;
        foreach ($sales as $sl) {
            $this->invoice_count += $sl['detail_count'];
            $this->sales_total += $sl->mhinvoicesubtotal_sum;
            $this->discount_total += $sl->mhinvoicediscounttotal_sum;
            $this->tax_total += $sl->mhinvoicetaxtotal_sum;
            $this->grandtotal_total += $sl->mhinvoicegrandtotal_sum;
        }

        $this->sales = $sales;
		$this->count = 0;
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $config->msysgenrounddec;
        $this->data['dec_point'] = $config->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['invoice_count_total'] = $this->invoice_count;
        $this->data['sales_total'] = $this->sales_total;
        $this->data['discount_total'] = $this->discount_total;
        $this->data['tax_total'] = $this->tax_total;
        $this->data['grandtotal_total'] = $this->grandtotal_total;

        $this->data['company'] = $config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
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

                $sheet->cell('J4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('K4',function($cell){
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
                $sheet->cell('J5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('K5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Customer','Tgl Invoice','Jumlah Invoice','Penjualan','Bonus Barang','Discount','Subtotal','PPN','Total','Retur','Total - Retur'
                ));
                foreach($this->sales as $sl){
                    $this->count++;
                    $sheet->row($this->count,array(
                        $sl->mhinvoicecustomername,
                        $sl->mhinvoicedate,
                        $sl->detail_count,
                        $sl->mhinvoicesubtotal - $sl->mhinvoicediscounttotal,
                        0,
                        $sl->mhinvoicediscounttotal,
                        $sl->mhinvoicesubtotal,
                        $sl->mhinvoicetaxtotal,
                        $sl->mhinvoicegrandtotal,
                        0,
                        $sl->mhinvoicegrandtotal,
                    ));
                }

                $this->count++;
                $sheet->row($this->count,array(
                    'TOTAL',
                    '',
                    $this->data['invoice_count_total'],
                    $this->data['sales_total'],
                    '0',
                    $this->data['discount_total'],
                    $this->data['sales_total'],
                    $this->data['tax_total'],
                    $this->data['grandtotal_total'],
                    '0',
                    $this->data['grandtotal_total'],
                ));

			});
		})->export('xls');
	}

    public function salesreport_csv(Request $request){

        $sales = [];
        $headers=[];

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

        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            // $sales = $header_query->whereIn('mhinvoiceno',$headers)->get();
            $sales = $header_query->whereIn('mhinvoiceno',$headers)->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = $header_query->groupBy('mhinvoicedate')
            ->selectRaw('*,sum(mhinvoicesubtotal) as mhinvoicesubtotal_sum,sum(mhinvoicediscounttotal) as mhinvoicediscounttotal_sum,sum(mhinvoicetaxtotal) as mhinvoicetaxtotal_sum,sum(mhinvoicegrandtotal) as mhinvoicegrandtotal_sum')
            ->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicedate',$s->mhinvoicedate)->get();
                $s['detail_count'] = count($details);

            }
        }

        $this->invoice_count =0;
        $this->sales_total =0;
        $this->discount_total =0;
        $this->tax_total =0;
        $this->grandtotal_total =0;
        foreach ($sales as $sl) {
            $this->invoice_count += $sl['detail_count'];
            $this->sales_total += $sl->mhinvoicesubtotal_sum;
            $this->discount_total += $sl->mhinvoicediscounttotal_sum;
            $this->tax_total += $sl->mhinvoicetaxtotal_sum;
            $this->grandtotal_total += $sl->mhinvoicegrandtotal_sum;
        }

        $this->sales = $sales;
        $this->count = 0;
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['decimals'] = $config->msysgenrounddec;
        $this->data['dec_point'] = $config->msysnumseparator;
        if($this->data['dec_point'] == ","){
          $this->data['thousands_sep'] = ".";
        } else {
          $this->data['thousands_sep'] = ",";
        }
        $this->data['invoice_count_total'] = $this->invoice_count;
        $this->data['sales_total'] = $this->sales_total;
        $this->data['discount_total'] = $this->discount_total;
        $this->data['tax_total'] = $this->tax_total;
        $this->data['grandtotal_total'] = $this->grandtotal_total;

        $this->data['company'] = $config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
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

                $sheet->cell('J4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('K4',function($cell){
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
                $sheet->cell('J5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('K5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Customer','Tgl Invoice','Jumlah Invoice','Penjualan','Bonus Barang','Discount','Subtotal','PPN','Total','Retur','Total - Retur'
                ));
                foreach($this->sales as $sl){
                    $this->count++;
                    $sheet->row($this->count,array(
                        $sl->mhinvoicecustomername,
                        $sl->mhinvoicedate,
                        $sl->detail_count,
                        $sl->mhinvoicesubtotal - $sl->mhinvoicediscounttotal,
                        0,
                        $sl->mhinvoicediscounttotal,
                        $sl->mhinvoicesubtotal,
                        $sl->mhinvoicetaxtotal,
                        $sl->mhinvoicegrandtotal,
                        0,
                        $sl->mhinvoicegrandtotal,
                    ));
                }

                $this->count++;
                $sheet->row($this->count,array(
                    'TOTAL',
                    '',
                    $this->data['invoice_count_total'],
                    $this->data['sales_total'],
                    '0',
                    $this->data['discount_total'],
                    $this->data['sales_total'],
                    $this->data['tax_total'],
                    $this->data['grandtotal_total'],
                    '0',
                    $this->data['grandtotal_total'],
                ));

            });
        })->export('csv');
	}

    public function invoicereport(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'invoicereports';
        $data['section'] = 'Invoice Report';
        return view('admin.invoicereport',$data);
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
        $queries = MDInvoice::on(Auth::user()->db_name);
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
        $queries = MDInvoice::on(Auth::user()->db_name);
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
        $queries = MDInvoice::on(Auth::user()->db_name);
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
        $queries = MDInvoice::on(Auth::user()->db_name);
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
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'arreports';
        $data['section'] = 'Laporan Piutang';
        return view('admin.arreport',$data);
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
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        $data['active'] = 'arcustreport';
        $data['section'] = 'AR Customer Report';
        return view('admin.arcustreport',$data);
    }

    public function arcustreport_print(Request $request){
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

        $header_query = MARCard::on(Auth::user()->db_name);
        if($request->has('cust')){
            $header_query->where('marcardcustomerid',$request->cust);
        }
        if($request->has('end')){
            $header_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        $headers = $header_query->get();
        $customers = [];
        foreach($headers as $h){
            array_push($customers,$h->marcardcustomerid);
        }
        $customers = array_unique($customers);

        $ar_detail_data = [];

        /*
         * Build detail data per customer head
         */
         $idx=0;
         $marcardoutstanding_total = 0;
        foreach ($customers as $cust) {
            $detail_query = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$cust);
            if($request->has('end')){
                $detail_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
            }
            $details = $detail_query->get();

            array_push($ar_detail_data,['customerid' => $cust,'customername' => $details[$idx]->marcardcustomername ,'header' => true]);
            foreach($details as $dt){
                $marcardoutstanding_total += $dt->marcardoutstanding;
                $dt['outstanding_prc'] = number_format($dt->marcardoutstanding,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $dt['aging'] = Carbon::now()->diffInDays(Carbon::parse($dt->marcarddate));
                $dt['trans_count'] = count(MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$dt->marcardtransno)->get());
                $dt['header'] = false;
                array_push($ar_detail_data,$dt);
            }
            $idx++;
        }

        $data['ars'] = $ar_detail_data;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $data['cust'] = $request->cust;
        $data['marcardoutstanding_total'] = number_format($marcardoutstanding_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
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
        return view('admin/export/arcustreport',$data);
    }

    public function arcustreport_pdf(Request $request){
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

        $header_query = MARCard::on(Auth::user()->db_name);
        if($request->has('cust')){
            $header_query->where('marcardcustomerid',$request->cust);
        }
        if($request->has('end')){
            $header_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        $headers = $header_query->get();
        $customers = [];
        foreach($headers as $h){
            array_push($customers,$h->marcardcustomerid);
        }
        $customers = array_unique($customers);

        $ar_detail_data = [];

        /*
         * Build detail data per customer head
         */
         $idx=0;
         $marcardoutstanding_total = 0;
        foreach ($customers as $cust) {
            $detail_query = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$cust);
            if($request->has('end')){
                $detail_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
            }
            $details = $detail_query->get();

            array_push($ar_detail_data,['customerid' => $cust,'customername' => $details[$idx]->marcardcustomername ,'header' => true]);
            foreach($details as $dt){
                $marcardoutstanding_total += $dt->marcardoutstanding;
                $dt['outstanding_prc'] = number_format($dt->marcardoutstanding,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
                $dt['aging'] = Carbon::now()->diffInDays(Carbon::parse($dt->marcarddate));
                $dt['trans_count'] = count(MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$dt->marcardtransno)->get());
                $dt['header'] = false;
                array_push($ar_detail_data,$dt);
            }
            $idx++;
        }

        $data['ars'] = $ar_detail_data;
        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        $data['cust'] = $request->cust;
        $data['marcardoutstanding_total'] = number_format($marcardoutstanding_total,$data['decimals'],$data['dec_point'],$data['thousands_sep']);
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
        $pdf = PDF::loadview('admin/export/arcustreport',$data);
		return $pdf->setPaper('a4', 'potrait')->download('AR Customer Report.pdf');
    }

    public function arcustreport_excel(Request $request){
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

        $header_query = MARCard::on(Auth::user()->db_name);
        if($request->has('cust')){
            $header_query->where('marcardcustomerid',$request->cust);
        }
        if($request->has('end')){
            $header_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        $headers = $header_query->get();
        $customers = [];
        foreach($headers as $h){
            array_push($customers,$h->marcardcustomerid);
        }
        $customers = array_unique($customers);

        $ar_detail_data = [];

        /*
         * Build detail data per customer head
         */
         $idx=0;
         $this->marcardoutstanding_total = 0;
        foreach ($customers as $cust) {
            $detail_query = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$cust);
            if($request->has('end')){
                $detail_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
            }
            $details = $detail_query->get();

            array_push($ar_detail_data,['customerid' => $cust,'customername' => $details[$idx]->marcardcustomername ,'header' => true]);
            foreach($details as $dt){
                $this->marcardoutstanding_total += $dt->marcardoutstanding;
                $dt['outstanding_prc'] = $dt->marcardoutstanding;
                $dt['aging'] = Carbon::now()->diffInDays(Carbon::parse($dt->marcarddate));
                $dt['trans_count'] = count(MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$dt->marcardtransno)->get());
                $dt['header'] = false;
                array_push($ar_detail_data,$dt);
            }
            $idx++;
        }
        $this->marcardoutstanding_total = $this->marcardoutstanding_total;
        $this->ars = $ar_detail_data;
        $this->request = $request;

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

                $sheet->cell('G4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('H4',function($cell){
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

                $sheet->cell('G5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('H5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Customer','Nama Customer','No Invoice','Tgl Invoice','Tgl Jatuh Tempo','Nilai Nota','Outstanding','Aging'
                ));

                foreach ($this->ars as $ar) {
                    $this->count++;
                    if($ar['header']){
                        $sheet->row($this->count,array(
                            $ar['customerid'],
                            $ar['customername'],
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $ar->marcardtransno,
                            $ar->marcarddate,
                            $ar->marcardduedate,
                            $ar['outstanding_prc'],
                            $ar['outstanding_prc'],
                            $ar['aging']
                        ));
                    }

                }

                $sheet->row($this->count,array(
                    'TOTAL',
                    '',
                    '',
                    '',
                    '',
                    $this->marcardoutstanding_total,
                    $this->marcardoutstanding_total,
                    ''
                ));


			});
		})->export('xls');
    }

    public function arcustreport_csv(Request $request){
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

        $header_query = MARCard::on(Auth::user()->db_name);
        if($request->has('cust')){
            $header_query->where('marcardcustomerid',$request->cust);
        }
        if($request->has('end')){
            $header_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
        }
        $headers = $header_query->get();
        $customers = [];
        foreach($headers as $h){
            array_push($customers,$h->marcardcustomerid);
        }
        $customers = array_unique($customers);

        $ar_detail_data = [];

        /*
         * Build detail data per customer head
         */
         $idx=0;
         $this->marcardoutstanding_total = 0;
        foreach ($customers as $cust) {
            $detail_query = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$cust);
            if($request->has('end')){
                $detail_query->whereDate('marcarddate','<=',Carbon::parse($request->end));
            }
            $details = $detail_query->get();

            array_push($ar_detail_data,['customerid' => $cust,'customername' => $details[$idx]->marcardcustomername ,'header' => true]);
            foreach($details as $dt){
                $this->marcardoutstanding_total += $dt->marcardoutstanding;
                $dt['outstanding_prc'] = $dt->marcardoutstanding;
                $dt['aging'] = Carbon::now()->diffInDays(Carbon::parse($dt->marcarddate));
                $dt['trans_count'] = count(MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$dt->marcardtransno)->get());
                $dt['header'] = false;
                array_push($ar_detail_data,$dt);
            }
            $idx++;
        }

        $this->ars = $ar_detail_data;
        $this->request = $request;
        $this->marcardoutstanding_total = $this->marcardoutstanding_total;
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

                $sheet->cell('G4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('H4',function($cell){
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

                $sheet->cell('G5',function($cell){
                    $cell->setValue('User');
                });
                $sheet->cell('H5',function($cell){
                    $cell->setValue(Auth::user()->name);
                });

                $this->count+=2;
                $sheet->row($this->count,array(
                    'Kode Customer','Nama Customer','No Invoice','Tgl Invoice','Tgl Jatuh Tempo','Nilai Nota','Outstanding','Aging'
                ));

                foreach ($this->ars as $ar) {
                    $this->count++;
                    if($ar['header']){
                        $sheet->row($this->count,array(
                            $ar['customerid'],
                            $ar['customername'],
                        ));
                    } else {
                        $sheet->row($this->count,array(
                            '',
                            '',
                            $ar->marcardtransno,
                            $ar->marcarddate,
                            $ar->marcardduedate,
                            $ar['outstanding_prc'],
                            $ar['outstanding_prc'],
                            $ar['aging']
                        ));
                    }

                }

                $sheet->row($this->count,array(
                    'TOTAL',
                    '',
                    '',
                    '',
                    '',
                    $this->marcardoutstanding_total,
                    $this->marcardoutstanding_total,
                    ''
                ));


			});
		})->export('csv');
    }

    public function stockreport_print(Request $request){
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
        // http://stackoverflow.com/questions/20731606/laravel-eloquent-inner-join-with-multiple-conditions
        // $query->join('mdinvoice',function($join){
        //     $join->on('mdinvoice.mhinvoiceno','=','mstockcard.mstockcardtransno');
        //     $join->on('mdinvoice.mdinvoicegoodsid','=','mstockcard.mstockcardgoodsid');
        // });
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['stocks'] = $query->get();

        foreach ($data['stocks'] as $d) {
            // get multi unit verbs
            if($d['mstockcardtranstype'] == 'Penjualan'){
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
                $verbs = UnitHelper::label($mgoods,$d->mstockcardstockout);
            } else {
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
                $verbs = UnitHelper::label($mgoods,$d->mstockcardstockin);
            }
            $d['verbs'] = $verbs;
        }

        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('wh')){
            $data['wh'] = $request->wh;
        } else {
            $data['wh'] = 'Semua';
        }
        if($request->has('goods')){
            $data['goods'] = $request->goods;
        } else {
            $data['goods'] = 'Semua';
        }
        return view('admin.export.stockreport',$data);
    }

    public function stockreport_pdf(Request $request){
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
        // http://stackoverflow.com/questions/20731606/laravel-eloquent-inner-join-with-multiple-conditions
        // $query->join('mdinvoice',function($join){
        //     $join->on('mdinvoice.mhinvoiceno','=','mstockcard.mstockcardtransno');
        //     $join->on('mdinvoice.mdinvoicegoodsid','=','mstockcard.mstockcardgoodsid');
        // });
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['stocks'] = $query->get();

        foreach ($data['stocks'] as $d) {
            // get multi unit verbs
            if($d['mstockcardtranstype'] == 'Penjualan'){
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
                $verbs = UnitHelper::label($mgoods,$d->mstockcardstockout);
            } else {
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
                $verbs = UnitHelper::label($mgoods,$d->mstockcardstockin);
            }
            $d['verbs'] = $verbs;
        }

        $data['company'] = $config->msyscompname;
        $data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('wh')){
            $data['wh'] = $request->wh;
        } else {
            $data['wh'] = 'Semua';
        }
        if($request->has('goods')){
            $data['goods'] = $request->goods;
        } else {
            $data['goods'] = 'Semua';
        }
        $pdf = PDF::loadview('admin/export/stockreport',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Stock Card Report.pdf');
    }

    public function stockreport_excel(Request $request){
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
        // http://stackoverflow.com/questions/20731606/laravel-eloquent-inner-join-with-multiple-conditions
        // $query->join('mdinvoice',function($join){
        //     $join->on('mdinvoice.mhinvoiceno','=','mstockcard.mstockcardtransno');
        //     $join->on('mdinvoice.mdinvoicegoodsid','=','mstockcard.mstockcardgoodsid');
        // });
        $this->config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['stocks'] = $query->get();
        foreach ($this->data['stocks'] as $d) {
            // get multi unit verbs
            if($d['mstockcardtranstype'] == 'Penjualan'){
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
                $verbs = UnitHelper::label($mgoods,$d->mstockcardstockout);
            } else {
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
                $verbs = UnitHelper::label($mgoods,$d->mstockcardstockin);
            }
            $d['verbs'] = $verbs;
        }
        $this->data['company'] = $this->config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('wh')){
            $this->data['wh'] = $request->wh;
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
                        $cell->setValue($this->request->wh);
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
                        $cell->setValue($this->request->goods);
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
                    'Kode Barang','Nama Barang','QTY Stock','Multi Satuan','Masuk','Keluar','Saldo','Tgl Trans','Tipe Trans','No Trans','Gudang','Cabang','Keterangan'
                ));

                foreach ($this->data['stocks'] as $st) {
                    $this->count++;
                    $sheet->row($this->count,array(
                        $st->mstockcardgoodsid,
                        $st->mstockcardgoodsname,
                        $st->mstockcardstocktotal,
                        $st['verbs'],
                        $st->mstockcardstockin,
                        $st->mstockcardstockout,
                        ($st->mstockcardstocktotal +$st->mstockcardstockin - $st->mstockcardstockout),
                        $st->mstockcarddate,
                        $st->mstockcardtranstype,
                        $st->mstockcardtransno,
                        $st->gudang()->mwarehousename,
                        'Umum',
                        ''
                    ));
                }


			});
		})->export('xls');
    }

    public function stockreport_csv(Request $request){
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
        // http://stackoverflow.com/questions/20731606/laravel-eloquent-inner-join-with-multiple-conditions
        // $query->join('mdinvoice',function($join){
        //     $join->on('mdinvoice.mhinvoiceno','=','mstockcard.mstockcardtransno');
        //     $join->on('mdinvoice.mdinvoicegoodsid','=','mstockcard.mstockcardgoodsid');
        // });

        $this->config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->data['stocks'] = $query->get();
        foreach ($this->data['stocks'] as $d) {
            // get multi unit verbs
            if($d['mstockcardtranstype'] == 'Penjualan'){
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
                $verbs = UnitHelper::label($mgoods,$d->mstockcardstockout);
            } else {
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$d->mstockcardgoodsid)->first();
                $verbs = UnitHelper::label($mgoods,$d->mstockcardstockin);
            }
            $d['verbs'] = $verbs;
        }
        $this->data['company'] = $this->config->msyscompname;
        $this->data['start'] = Carbon::parse($request->start)->formatLocalized('%d %B %Y');
        $this->data['end'] = Carbon::parse($request->end)->formatLocalized('%d %B %Y');
        if($request->has('wh')){
            $this->data['wh'] = $request->wh;
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
                        $cell->setValue($this->request->wh);
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
                        $cell->setValue($this->request->goods);
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
                    'Kode Barang','Nama Barang','QTY Stock','Multi Satuan','Masuk','Keluar','Saldo','Tgl Trans','Tipe Trans','No Trans','Gudang','Cabang','Keterangan'
                ));

                foreach ($this->data['stocks'] as $st) {
                    $this->count++;
                    $sheet->row($this->count,array(
                        $st->mstockcardgoodsid,
                        $st->mstockcardgoodsname,
                        $st->mstockcardstocktotal,
                        $st['verbs'],
                        $st->mstockcardstockin,
                        $st->mstockcardstockout,
                        ($st->mstockcardstocktotal +$st->mstockcardstockin - $st->mstockcardstockout),
                        $st->mstockcarddate,
                        $st->mstockcardtranstype,
                        $st->mstockcardtransno,
                        $st->gudang()->mwarehousename,
                        'Umum',
                        ''
                    ));
                }


			});
		})->export('csv');
    }
}
