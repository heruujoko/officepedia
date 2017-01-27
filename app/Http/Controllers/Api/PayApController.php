<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHPayAP;
use App\MDPayAP;
use Datatables;
use Auth;
use App\MSupplier;


class PayApController extends Controller
{

    public function index(){
        $payapdata = MHPayAP::on(Auth::user()->db_name)->get();
        $this->iteration = 0;
        return Datatables::of($payapdata)->addColumn('action', function($pap){
            $menus = "";
            $menus .= '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmpayap('.$pap->id.')"> <font style="">Lihat</font></a>';
            if(Auth::user()->has_role('U_payap')){
                $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmpayap('.$pap->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
            }
            if(Auth::user()->has_role('D_payap')){
                $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$pap->id.')">
              <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
            }
          return $menus;
        })->addColumn('no',function($pap){
                $this->iteration++;
                return "<span>".$this->iteration."</span>";
        })
        ->addColumn('outstanding',function($pap){
            return "<span text-align=\"right\">".($pap->mhpayapsubtotal - $pap->mhpayappayamount)."</span>";
        })
        ->make(true);
    }

    public function show($id){
        $mhpayap = MHPayAP::on(Auth::user()->db_name)->where('id',$id)->first();
        $mhpayap['supplier_id'] = MSupplier::on(Auth::user()->db_name)->where('msupplierid',$mhpayap->mhpayapsupplierno)->first()->id;
        return response()->json($mhpayap);
    }

    public function details($invoice_no){
        $mdpayap = MDPayAp::on(Auth::user()->db_name)->where('mhpayapno',$invoice_no)->get();
        return response()->json($mdpayap);
    }

    public function store(Request $request){
        $transaction = MHPayAP::start_transaction($request);
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }

    public function update($id,Request $request){
        $ap = MHPayAP::on(Auth::user()->db_name)->where('id',$id)->first();
        $transaction = $ap->update_transaction($request);
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }

    public function destroy($id){
        $ap = MHPayAP::on(Auth::user()->db_name)->where('id',$id)->first();
        $transaction = $ap->delete_transaction();
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }

}
