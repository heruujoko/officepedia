<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Auth;
use App\MHInvoice;
use App\MDInvoice;
use App\MConfig;
use App\Http\Requests;
use Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function salesreport(){
        $data['active'] = 'reports';
        $data['section'] = 'Sales Report';
        return view('admin.salesreport',$data);
    }

    public function salesreport_print(Request $request){

        $sales = [];
        $headers=[];
        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = MHInvoice::on(Auth::user()->db_name)->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        }

        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['sales'] = $sales;
        return view('admin/export/salesreport',$data);
    }

    public function salesreport_pdf(Request $request){
        $sales = [];
        $headers=[];
        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = MHInvoice::on(Auth::user()->db_name)->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        }

        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $data['decimals'] = $config->msysgenrounddec;
        $data['dec_point'] = $config->msysnumseparator;
        if($data['dec_point'] == ","){
          $data['thousands_sep'] = ".";
        } else {
          $data['thousands_sep'] = ",";
        }

        $data['sales'] = $sales;
        $pdf = PDF::loadview('admin/export/salesreport',$data);
		return $pdf->setPaper('a4', 'potrait')->download('Sales Report.pdf');
    }

    public function salesreport_excel(Request $request){

        $sales = [];
        $headers=[];
        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = MHInvoice::on(Auth::user()->db_name)->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
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
		return Excel::create('Sales Report',function($excel){
			$excel->sheet('Sales Report',function($sheet){
				$this->count++;
                $sheet->mergeCells('A1:K1');
                $sheet->row($this->count,array('PT Officepedia Solusindo'));
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
                $sheet->row($this->count,array('Periode 1 November - 30 November'));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('J4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('K4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
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
                        number_format($sl->mhinvoicesubtotal - $sl->mhinvoicediscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format(0,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicediscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicesubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicetaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicegrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format(0,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicegrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                    ));
                }


			});
		})->export('xlsx');
	}

    public function salesreport_csv(Request $request){

        $sales = [];
        $headers=[];
        if($request->has('goods') && $request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }

        } else if($request->has('wh')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsidwhouse',$request->wh)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        }else if($request->has('goods')){
            $details = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$request->goods)->get();
            foreach ($details as $d) {
                array_push($headers,$d->mhinvoiceno);
            }
            $headers = array_unique($headers);
            $sales = MHInvoice::on(Auth::user()->db_name)->whereIn('mhinvoiceno',$headers)->get();
            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
        } else {
            $sales = MHInvoice::on(Auth::user()->db_name)->get();

            foreach($sales as $s){

                $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$s->mhinvoiceno)->get();
                $s['detail_count'] = count($details);

            }
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
        return Excel::create('Sales Report',function($excel){
            $excel->sheet('Sales Report',function($sheet){
                $this->count++;
                $sheet->mergeCells('A1:K1');
                $sheet->row($this->count,array('PT Officepedia Solusindo'));
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
                $sheet->row($this->count,array('Periode 1 November - 30 November'));
                $sheet->cell('A3',function($cell){
                    $cell->setAlignment('center');
                });
                $this->count+=2;

                $sheet->cell('J4',function($cell){
                    $cell->setValue('Tgl Cetak/ Jam');
                });
                $sheet->cell('K4',function($cell){
                    $cell->setValue(Carbon::now());
                });

                $this->count++;
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
                        number_format($sl->mhinvoicesubtotal - $sl->mhinvoicediscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format(0,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicediscounttotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicesubtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicetaxtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicegrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format(0,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                        number_format($sl->mhinvoicegrandtotal,$this->data['decimals'],$this->data['dec_point'],$this->data['thousands_sep']),
                    ));
                }


            });
        })->export('csv');
    }
}
