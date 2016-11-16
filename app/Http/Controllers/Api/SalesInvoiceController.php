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

class SalesInvoiceController extends Controller
{

    public function index(){
      $this->iteration = 0;
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->round = $config->msysgenrounddec;
      $this->separator = $config->msysnumseparator;
      $minvoice = MHInvoice::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
      return Datatables::of($minvoice)->addColumn('action', function($invoice){
      return '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewinvoice('.$invoice->id.')"> <font style="">Lihat</font></a>
            <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editinvoice('.$invoice->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
            <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$invoice->id.')">
          <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
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

      $transcation = MHInvoice::start_transaction($request);
      if($transcation){
          return response()->json($transcation);
      } else {
          return response()->json($transcation,400);
      }

    }

    public function show($id){
      $invoice = MHInvoice::on(Auth::user()->db_name)->where('id',$id)->first();
      return response()->json($invoice);
    }

    public function details($inv){
      $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$inv)->get();
      return response()->json($details);
    }

    public function destroy($id){
      $invoice = MHInvoice::on(Auth::user()->db_name)->where('id',$id)->first();
      $invoice->void_transaction();
      return response()->json();
    }
}
