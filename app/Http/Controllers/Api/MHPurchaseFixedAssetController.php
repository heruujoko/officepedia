<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHPurchaseFA;
use App\MDPurchaseFA;
use App\MCategoryfixedassets;
use Datatables;
use Auth;

class MHPurchaseFixedAssetController extends Controller
{

    public function index(){
      $this->iteration = 0;
      $purch = MHPurchaseFA::on(Auth::user()->db_name)->where('void',0)->get();
      return Datatables::of($purch)->addColumn('action', function($pr){
        $menus = '<center><div class="button">';
        $menus .= '<a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewinvoice('.$pr->id.')"> <font style="">Lihat</font></a>';
        $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editinvoice('.$pr->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
        $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$pr->id.')"><input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';

        return $menus;
      })->addColumn('no',function($pr){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })
      ->addColumn('categoryname',function($pr){
          $cat = MCategoryfixedassets::on(Auth::user()->db_name)->where('id',$pr->mhpurchasefixedassetcategory)->first();
          return "<span>".$cat->mcategoryfixedassetgroupname."</span>";
      })
      ->make(true);
    }

    public function store(Request $request){

      $trans = MHPurchaseFA::start_transaction($request);

      if($trans == 'ok'){
        return response()->json('ok');
      } else {
        return response()->json('err',500);
      }

    }

    public function update(Request $request,$id){

      $trans = MHPurchaseFA::update_transaction($id,$request);

      if($trans == 'ok'){
        return response()->json('ok');
      } else {
        return response()->json('err',500);
      }
    }

    public function show($id){
      $purch = MHPurchaseFA::on(Auth::user()->db_name)->where('id',$id)->first();
      return response()->json($purch);
    }

    public function details($id){
      $purch = MHPurchaseFA::on(Auth::user()->db_name)->where('id',$id)->first();
      $details = MDPurchaseFA::on(Auth::user()->db_name)->where('mhpurchasefixedassetno',$purch->mhpurchasefixedassetno)->where('void',0)->get();
      return response()->json($details);
    }

    public function destroy($id){
      $trans = MHPurchaseFA::delete_transaction($id);
      if($trans == 'ok'){
        return response()->json('ok');
      } else {
        return response()->json('err',500);
      }  
    }
}
