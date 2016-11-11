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

    public function destroy($id){
      $invoice = MHInvoice::on(Auth::user()->db_name)->where('id',$id)->first();
      $invoice->void_transaction();
      return response()->json();
    }
}
