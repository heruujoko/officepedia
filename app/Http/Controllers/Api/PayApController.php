<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHPayAP;
use Datatables;
use Auth;


class PayApController extends Controller
{

    public function index(){
        $payapdata = MHPayAP::on(Auth::user()->db_name)->get();
        $this->iteration = 0;
        return Datatables::of($payapdata)->addColumn('action', function($pap){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcategory('.$pap->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcategory('.$pap->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$pap->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($pap){
                $this->iteration++;
                return "<span>".$this->iteration."</span>";
        })
        ->addColumn('outstanding',function($pap){
            return "<span text-align=\"right\">".($pap->mhpayapsubtotal - $pap->mhpayappayamount)."</span>";
        })
        ->make(true);
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

}
