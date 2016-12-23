<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHPurchasequotation;
use App\MDPurchasequotation;
use App\MConfig;
use Auth;
use Datatables;
use Carbon\Carbon;



class PurchasequotationController extends Controller
{
	public function index(){

		 $this->iteration = 0;
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->round = $config->msysgenrounddec;
        $this->separator = $config->msysnumseparator;
        $minvoice = MHPurchasequotation::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
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
        $quotation = new MHPurchasequotation($request->all());
        $quotation->setConnection(Auth::user()->db_name);
        $quotation->mhpurchasequotationdeliveryno = $request->mhpurchasequotationdeliveryno;
        $quotation->mhpurchasequotationorderyno = $request->mhpurchasequotationorderyno;
        $quotation->mhpurchasequotationdate = Carbon::parse($request->mhpurchasequotationdate);
        $quotation->mhpurchasequotationduedate = Carbon::parse($request->mhpurchasequotationduedate);
        $quotation->mhpurchasequotationsubtotal = $request->mhpurchasequotationsubtotal;
        $quotation->mhpurchasequotationtaxtotal = $request->mhpurchasequotationtaxtotal;
        $quotation->mhpurchasequotationdiscounttotal = $request->mhpurchasequotationdiscounttotal;
        $quotation->mhpurchasequotationgrandtotal = $request->mhpurchasequotationsubtotal + $request->mhpurchasequotationtaxtotal;
        $quotation->mhpurchasequotationothertotal = 0;
        $quotation->mhpurchasequotationwithppn = 0;
        $quotation->void = 0;
        $quotation->save();
        if ($request->autogen == true) {
            $quotation->autogenproc();
        }
        else{
        $quotation->mhpurchasequotationno = $request->no;
        }

        $quotation->save();
        $header = MHPurchasequotation::on(Auth::user()->db_name)->where('id',$quotation->id)->first();
        foreach($request->goods as $g){
          $detail = new MDPurchasequotation;
          $detail->setConnection(Auth::user()->db_name);
          $detail->mhpurchaquotationseno = $header->mhpurchasequotationno;
          $detail->mdpurchasequotationsupplierid = $g['goods']['mgoodssuppliercode'];
          $detail->mdpurchasequotationsuppliername = $g['goods']['mgoodssuppliername'];
          $detail->mdpurchasequotationdate = $header->mhpurchasequotationdate;
          $detail->mdpurchasequotationgoodsid = $g['goods']['mgoodscode'];
          $detail->mdpurchasequotationgoodsname = $g['goods']['mgoodsname'];
          $detail->mdpurchasequotationgoodsunit3conv = $g['goods']['mgoodsunit3conv'];
          $detail->mdpurchasequotationgoodsunit3label = $g['goods']['mgoodsunit3'];
          $detail->mdpurchasequotationgoodsunit2conv = $g['goods']['mgoodsunit2conv'];
          $detail->mdpurchasequotationgoodsunit2label = $g['goods']['mgoodsunit2'];
          $detail->mdpurchasequotationgoodsunit1label = $g['goods']['mgoodsunit'];
          $detail->mdpurchasequotationgoodsprice = $g['goods']['mgoodspriceout'];
          $detail->mdpurchasequotationgoodsgrossamount = $g['subtotal'];
          $detail->mdpurchasequotationgoodsdiscount = $g['disc'];
          $detail->mdpurchasequotationgoodsidwhouse = $g['warehouse'];
          $detail->mdpurchasequotationremarks = $g['remark'];
          $detail->save();
        }
        return response()->json($quotation);
    }

	public function show(){

	}
	public function update(){

	}
	public function destroy(){

	}
}