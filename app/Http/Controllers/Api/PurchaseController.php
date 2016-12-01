<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHPurchase;
use App\MConfig;
use Auth;
use Datatables;

class PurchaseController extends Controller
{

    public function index(){
        $this->iteration = 0;
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->round = $config->msysgenrounddec;
        $this->separator = $config->msysnumseparator;
        $minvoice = MHPurchase::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
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
          $formatted_saldo = number_format($invoice->mhpurchasesubtotal,$decimals,$dec_point,$thousands_sep);
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
          $formatted_saldo = number_format($invoice->mhpurchasetaxtotal,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })->addColumn('disc',function($invoice){
          $decimals = $this->round;
          $dec_point = $this->separator;
          if($dec_point == ","){
            $thousands_sep = ".";
          } else {
            $thousands_sep = ",";
          }
          $formatted_saldo = number_format($invoice->mhpurchasediscounttotal,$decimals,$dec_point,$thousands_sep);
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
          $formatted_saldo = number_format($invoice->mhpurchasegrandtotal,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })
        ->make(true);
    }

    public function store(Request $request){
        $transaction = MHPurchase::start_transaction($request);
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }
}
