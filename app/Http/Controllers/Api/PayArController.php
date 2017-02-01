<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHPayAR;
use App\MDPayAR;
use App\MCUSTOMER;
use Auth;
use Datatables;
use App\MBRANCH;
use App\MWarehouse;

class PayArController extends Controller
{

    public function index(){
        $payardata = MHPayAR::on(Auth::user()->db_name)->get();
        $this->iteration = 0;

        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();
        $warehouses = MWarehouse::on(Auth::user()->db_name)->where('mwarehousebranchid',$branch->mbranchcode)->get()->toArray();

        $warehouse_ids = array_map(function($w){
            return $w['id'];
        },$warehouses);

        $payar_branch = collect();

        foreach($payardata as $ar){
            if($ar->has_detail_in_warehouses($warehouse_ids)){
                $payar_branch->push($ar);
            }
        }

        return Datatables::of($payar_branch)->addColumn('action', function($pap){
            $menus = '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmpayar('.$pap->id.')"> <font style="">Lihat</font></a>';

            if(Auth::user()->has_role('U_payar')){
                $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmpayar('.$pap->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
            }
            if(Auth::user()->has_role('D_payar')){
                $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$pap->id.')">
              <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
            }
          return $menus;
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

    public function update($id,Request $request){
        $ar = MHPayAR::on(Auth::user()->db_name)->where('id',$id)->first();
        $transaction = $ar->update_transaction($request);
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }

    public function destroy($id){
        $ar = MHPayAR::on(Auth::user()->db_name)->where('id',$id)->first();
        $transaction = $ar->delete_transaction();
        if($transaction == "ok"){
            return response()->json($transaction);
        } else if($transaction == "empty") {
            return response()->json($transaction,400);
        } else {
            return response()->json($transaction,500);
        }
    }
}
