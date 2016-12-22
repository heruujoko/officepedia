<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHPayAR;
use App\MCustomer;
use Auth;
use Datatables;

class PayArController extends Controller
{

    public function index(){
        $payardata = MHPayAR::on(Auth::user()->db_name)->get();
        $this->iteration = 0;
        return Datatables::of($payardata)->addColumn('action', function($pap){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmpayar('.$pap->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmpayar('.$pap->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$pap->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($pap){
                $this->iteration++;
                return "<span>".$this->iteration."</span>";
        })
        ->addColumn('outstanding',function($pap){
            return "<span text-align=\"right\">".($pap->mhpayarsubtotal - $pap->mhpayarpayamount)."</span>";
        })
        ->make(true);
    }

    public function show($id){
        $mhpayar = MHPayAR::on(Auth::user()->db_name)->where('id',$id)->first();
        $mhpayar['customer_id'] = MCustomer::on(Auth::user()->db_name)->where('mcustomerid',$mhpayar->mhpayarcustomerno)->first()->id;
        return response()->json($mhpayar);
    }

    public function details($invoice_no){
        $mdpayar = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$invoice_no)->get();
        return response()->json($mdpayar);
    }

    public function store(Request $request){
        $transaction = MHPayAR::start_transaction($request);
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }
}
