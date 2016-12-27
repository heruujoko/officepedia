<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHPurchase;
use App\MDPurchase;
use App\MConfig;
use Auth;
use Datatables;
use Carbon\Carbon;

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

    public function show($id){
        $purchase = MHPurchase::on(Auth::user()->db_name)->where('id',$id)->first();
        return response()->json($purchase);
    }

    public function details($inv){
        $details = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$inv)->where('void',0)->get();
        return response()->json($details);
    }

    public function update($id,Request $request){
        $transaction = MHPurchase::update_transaction($id,$request);
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }

    public function destroy($id){
        $transaction = MHPurchase::delete_transaction($id);
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }

    public function purchasereport(Request $request){
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
            $grp_q = MDPurchase::on(Auth::user()->db_name)->where('mdpurchasedate',$dates)->where('void',0);;

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
        return response()->json($purchases);
    }
}
