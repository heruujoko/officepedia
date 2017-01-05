<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MHSalesquotation;
use App\MDSalesquotation;
use App\MConfig;
use Auth;
use Datatables;
use Carbon\Carbon;
class SalesquotationController extends Controller
{
    public function index(){

		 $this->iteration = 0;
        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->round = $config->msysgenrounddec;
        $this->separator = $config->msysnumseparator;
        $mdquotation = MHSalesquotation::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        $mquotation = MHSalesquotation::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();

        return Datatables::of($mquotation)->addColumn('action', function($quotation){
        return '<center><div class="button">
              <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewquotation('.$quotation->id.')"> <font style="">Lihat</font></a>
              <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editquotation('.$quotation->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
              <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$quotation->id.')">
            <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>  <a class="btn btn-default btn-xs dropdown-toggle" onclick="print2('.$quotation->id.')"> <font style="">Print</font></a>    </div></center>';
        })->addColumn('no',function($quotation){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
        })
        ->addColumn('subtotal',function($quotation){
          $decimals = $this->round;
          $dec_point = $this->separator;
          if($dec_point == ","){
            $thousands_sep = ".";
          } else {
            $thousands_sep = ",";
          }
          $formatted_saldo = number_format($quotation->mhsalessubtotal,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })
        ->addColumn('tax',function($quotation){
          $decimals = $this->round;
          $dec_point = $this->separator;
          if($dec_point == ","){
            $thousands_sep = ".";
          } else {
            $thousands_sep = ",";
          }
          $formatted_saldo = number_format($quotation->mhsalestaxtotal,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })->addColumn('disc',function($quotation){
          $decimals = $this->round;
          $dec_point = $this->separator;
          if($dec_point == ","){
            $thousands_sep = ".";
          } else {
            $thousands_sep = ",";
          }
          $formatted_saldo = number_format($quotation->mhsalesdiscounttotal,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })
        ->addColumn('gtotal',function($quotation){
          $decimals = $this->round;
          $dec_point = $this->separator;
          if($dec_point == ","){
            $thousands_sep = ".";
          } else {
            $thousands_sep = ",";
          }
          $formatted_saldo = number_format($quotation->mhsalesgrandtotal,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })
        ->make(true);

	}
    public function details($inv){
        $details = MDSalesquotation::on(Auth::user()->db_name)->where('mhsalesotationseno',$inv)->where('void',0)->get();
        return response()->json($details);
    }
	 public function store(Request $request){
        $quotation = new MHSalesquotation($request->all());
        $quotation->setConnection(Auth::user()->db_name);
        $quotation->mhsalesquotationdeliveryno = $request->mhsalesquotationdeliveryno;
        $quotation->mhsalesquotationorderyno = $request->mhsalesquotationorderyno;
        $quotation->mhsalesquotationdate = Carbon::parse($request->mhsalesquotationdate);
        $quotation->mhsalesquotationduedate = Carbon::parse($request->mhsalesquotationduedate);
        $quotation->mhsalesquotationsubtotal = $request->mhsalesquotationsubtotal;
        $quotation->mhsalesquotationtaxtotal = $request->mhsalesquotationtaxtotal;
        $quotation->mhsalesquotationdiscounttotal = $request->mhsalesquotationdiscounttotal;
        $quotation->mhsalesquotationgrandtotal = $request->mhsalesquotationsubtotal + $request->mhsalesquotationtaxtotal;
        $quotation->mhsalesquotationothertotal = 0;
        $quotation->mhsalesquotationwithppn = 0;
        $quotation->void = 0;
        $quotation->save();
        if ($request->autogen == true) {
            $quotation->autogenproc();
        }
        else{
        $quotation->mhsalesquotationno = $request->no;
        }

        $quotation->save();
        $header = MHSalesquotation::on(Auth::user()->db_name)->where('id',$quotation->id)->first();
        foreach($request->goods as $g){
          $detail = new MDSalesquotation;
          $detail->setConnection(Auth::user()->db_name);
          $detail->mhsalesotationseno = $header->mhsalesquotationno;
          $detail->mdsalesquotationsupplierid = $g['goods']['mgoodssuppliercode'];
          $detail->mdsalesquotationsuppliername = $g['goods']['mgoodssuppliername'];
          $detail->mdsalesquotationdate = $header->mhsalesquotationdate;
          $detail->mdsalesquotationgoodsid = $g['goods']['mgoodscode'];
          $detail->mdsalesquotationgoodsname = $g['goods']['mgoodsname'];
          $detail->mdsalesquotationgoodsunit3conv = $g['goods']['mgoodsunit3conv'];
          $detail->mdsalesquotationgoodsunit3label = $g['goods']['mgoodsunit3'];
          $detail->mdsalesquotationgoodsunit2conv = $g['goods']['mgoodsunit2conv'];
          $detail->mdsalesquotationgoodsunit2label = $g['goods']['mgoodsunit2'];
          $detail->mdsalesquotationgoodsunit1label = $g['goods']['mgoodsunit'];
          $detail->mdsalesquotationgoodsprice = $g['goods']['mgoodspriceout'];
          $detail->mdsalesquotationgoodsgrossamount = $g['subtotal'];
          $detail->mdsalesquotationgoodsdiscount = $g['disc'];
          $detail->mdsalesquotationgoodsidwhouse = $g['warehouse'];
          $detail->mdsalesquotationremarks = $g['remark'];
          $detail->save();
        }
        return response()->json($quotation);
    }

	public function show($id){
      $purchase = MHSalesquotation::on(Auth::user()->db_name)->where('id',$id)->first();
        return response()->json($purchase);
	}

	public function update($id,Request $request){

        $quotation = MHSalesquotation::on(Auth::user()->db_name)->where('id',$id)->first();
        $quotation->mhsalesquotationdeliveryno = $request->deliveryno;
        $quotation->mhsalesquotationorderyno = $request->orderyno;
        $quotation->mhsalesquotationdate = Carbon::parse($request->date);
        $quotation->mhsalesquotationduedate = Carbon::parse($request->duedate);
        $quotation->mhsalesquotationsubtotal = $request->subtotal;
        $quotation->mhsalesquotationtaxtotal = $request->taxtotal;
        $quotation->mhsalesquotationdiscounttotal = $request->discounttotal;
        $quotation->mhsalesquotationgrandtotal = $request->subtotal + $request->taxtotal;
        $quotation->mhsalesquotationothertotal = 0;
        $quotation->mhsalesquotationwithppn = 0;
        $quotation->void = 0;

        if ($request->autogen == true) {
            $quotation->autogenproc();
        }
        else{
        $quotation->mhsalesquotationno = $request->no;
        }

        $quotation->save();

        $header = MHSalesquotation::on(Auth::user()->db_name)->where('id',$quotation->id)->first();
        $headers = MDSalesquotation::on(Auth::user()->db_name)->where('mhsalesotationseno',$quotation->mhsalesquotationno)->delete();

        foreach($request->goods as $g){

          $detail = new MDSalesquotation;
          $detail->setConnection(Auth::user()->db_name);
          $detail->mhsalesotationseno = $header->mhsalesquotationno;
          $detail->mdsalesquotationsupplierid = $g['goods']['mgoodssuppliercode'];
          $detail->mdsalesquotationsuppliername = $g['goods']['mgoodssuppliername'];
          $detail->mdsalesquotationdate = $header->mhsalesquotationdate;
          $detail->mdsalesquotationgoodsid = $g['goods']['mgoodscode'];
          $detail->mdsalesquotationgoodsname = $g['goods']['mgoodsname'];
          $detail->mdsalesquotationgoodsunit3conv = $g['goods']['mgoodsunit3conv'];
          $detail->mdsalesquotationgoodsunit3label = $g['goods']['mgoodsunit3'];
          $detail->mdsalesquotationgoodsunit2conv = $g['goods']['mgoodsunit2conv'];
          $detail->mdsalesquotationgoodsunit2label = $g['goods']['mgoodsunit2'];
          $detail->mdsalesquotationgoodsunit1label = $g['goods']['mgoodsunit'];
          $detail->mdsalesquotationgoodsprice = $g['goods']['mgoodspriceout'];
          $detail->mdsalesquotationgoodsgrossamount = $g['subtotal'];
          $detail->mdsalesquotationgoodsdiscount = $g['disc'];
          $detail->mdsalesquotationgoodsidwhouse = $g['warehouse'];
          $detail->mdsalesquotationremarks = $g['goods']['mgoodsremark'];
          $detail->save();
        }

        return response()->json($quotation);
	}
	public function destroy($id){
    $mbrand = MHSalesquotation::on(Auth::user()->db_name)->where('id',$id)->first();
    $mbrand->void = 1;
    $mbrand->save();
    return response()->json($mbrand,200);
	}
}
