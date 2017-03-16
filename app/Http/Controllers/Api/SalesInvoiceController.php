<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHInvoice;
use App\MDInvoice;
use App\MCUSTOMER;
use App\MConfig;
use Auth;
use Carbon\Carbon;
use Datatables;
use App\MBRANCH;
use App\MWarehouse;

class SalesInvoiceController extends Controller
{

    public function index(){
      $this->iteration = 0;
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->round = $config->msysgenrounddec;
      $this->separator = $config->msysnumseparator;

      $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();
      $warehouses = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$branch->mbranchcode)->get()->toArray();

      $warehouse_ids = array_map(function($w){
          return $w['id'];
      },$warehouses);

      $minvoice = MHInvoice::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
      $branch_invoice = collect();
      foreach($minvoice as $iv){
          if($iv->has_item_in_warehouses($warehouse_ids)){
              $branch_invoice->push($iv);
          }
      }

      return Datatables::of($branch_invoice)->addColumn('action', function($invoice){
            $menus = '<center><div class="button">
                <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewinvoice('.$invoice->id.')"> <font style="">Lihat</font></a>';

            if(Auth::user()->has_role('U_sales')){
                $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editinvoice('.$invoice->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
            }
            if(Auth::user()->has_role('D_sales')){
                $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$invoice->id.')">
              <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
            }
            return $menus;

      })->addColumn('no',function($invoice){
        $this->iteration++;
        return "<span>".$this->iteration."</span>";
      })
      ->addColumn('subtotal',function($invoice){
        $decimals = $this->round;
        $dec_point = $this->separator;
        if($dec_point == ","){
          $thousands_sep = ".";
        } else {
          $thousands_sep = ",";
        }
        $formatted_saldo = number_format($invoice->mhinvoicesubtotal,$decimals,$dec_point,$thousands_sep);
        return "<span style=\"float:right\">".$formatted_saldo."</span>";
      })
      ->addColumn('tax',function($invoice){
        $decimals = $this->round;
        $dec_point = $this->separator;
        if($dec_point == ","){
          $thousands_sep = ".";
        } else {
          $thousands_sep = ",";
        }
        $formatted_saldo = number_format($invoice->mhinvoicetaxtotal,$decimals,$dec_point,$thousands_sep);
        return "<span style=\"float:right\">".$formatted_saldo."</span>";
      })->addColumn('disc',function($invoice){
        $decimals = $this->round;
        $dec_point = $this->separator;
        if($dec_point == ","){
          $thousands_sep = ".";
        } else {
          $thousands_sep = ",";
        }
        $formatted_saldo = number_format($invoice->mhinvoicediscounttotal,$decimals,$dec_point,$thousands_sep);
        return "<span style=\"float:right\">".$formatted_saldo."</span>";
      })
      ->addColumn('gtotal',function($invoice){
        $decimals = $this->round;
        $dec_point = $this->separator;
        if($dec_point == ","){
          $thousands_sep = ".";
        } else {
          $thousands_sep = ",";
        }
        $formatted_saldo = number_format($invoice->mhinvoicegrandtotal,$decimals,$dec_point,$thousands_sep);
        return "<span style=\"float:right\">".$formatted_saldo."</span>";
      })
      ->make(true);
    }

    public function store(Request $request){

      $transaction = MHInvoice::start_transaction($request);
      if($transaction['status'] == "ok"){
          $invoice = MHInvoice::on(Auth::user()->db_name)->where('id',$transaction['data']->id)->first();
          return response()->json($invoice);
      } else if($transaction['status'] == "empty") {
          return response()->json($transaction,400);
      } else {
          return response()->json($transaction,500);
      }

    }

    public function update($id, Request $request){
      $header = MHInvoice::on(Auth::user()->db_name)->where('id',$id)->first();
      $transaction = $header->update_transaction($request);
      if($transaction['status'] == "ok"){
          return response()->json($transaction['data']);
      } else if($transaction['status'] == "empty") {
          return response()->json($transaction,400);
      } else {
          return response()->json($transaction,500);
      }
    }

    public function show($id){
      $invoice = MHInvoice::on(Auth::user()->db_name)->where('id',$id)->first();
      return response()->json($invoice);
    }

    public function details($inv){
      $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$inv)->where('void',0)->get();
      return response()->json($details);
    }

    public function destroy($id){
      $transaction = MHInvoice::void_transaction($id);
      if($transaction == "ok"){
          return response()->json($transaction);
      } else if($transaction == "empty") {
          return response()->json($transaction,400);
      } else {
          return response()->json($transaction,500);
      }
    }
}
