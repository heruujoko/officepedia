<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MGoods;
use DB;
use Datatables;
use Validator;
use Exception;
use App\MConfig;
use Auth;

class MGoodsController extends Controller
{

  private $round;
  private $separator;
  private $iteration;

  private function convertBoolean($string_bool){
      if($string_bool == "true"){
        return 1;
      } else {
        return 0;
      }
  }

  private function convertint($string_bool){
      if($string_bool){
        return 1;
      } else {
        return 0;
      }
  }

	public function index(){
		 $this->iteration = 0;
     $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
     $this->round = $config->msysgenrounddec;
     $this->separator = $config->msysnumseparator;

        $MGoods = MGoods::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($MGoods)->addColumn('action', function($MGoods){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmgoods('.$MGoods->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmgoods('.$MGoods->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$MGoods->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($MGoods){
            $this->iteration++;
            return "<span style=\"float:right\">".$this->iteration."</span>";
        })
        ->addColumn('category',function($MGoods){
            return "<span>".$MGoods->category()->category_name."</span>";
        })
        ->addColumn('brand',function($MGoods){
            return "<span>".$MGoods->mark()."</span>";
        })
        ->addColumn('type',function($MGoods){
            return "<span>".$MGoods->types()."</span>";
        })
        ->addColumn('subtype',function($MGoods){
            return "<span>".$MGoods->subtypes()."</span>";
        })
        ->addColumn('supplier',function($MGoods){
            return "<span>".$MGoods->supplier()."</span>";
        })
        ->addColumn('pricein',function($MGoods){
          $decimals = $this->round;
          $dec_point = $this->separator;
          if($dec_point == ","){
            $thousands_sep = ".";
          } else {
            $thousands_sep = ",";
          }
          $formatted_saldo = number_format($MGoods->mgoodspricein,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })
        ->addColumn('priceout',function($MGoods){
          $decimals = $this->round;
          $dec_point = $this->separator;
          if($dec_point == ","){
            $thousands_sep = ".";
          } else {
            $thousands_sep = ",";
          }
          $formatted_saldo = number_format($MGoods->mgoodspriceout,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })
        ->make(true);
	}

  public function datalist(){
    $goods = MGoods::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
    return response()->json($goods);
  }
  public function pkp(){
    $goods = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
    return response()->json($goods);
  }
	public function show($id){
		$MGoods = MGoods::on(Auth::user()->db_name)->where('id',$id)->first();
      	return response()->json($MGoods);
	}

    public function store(Request $request){
      $MGoods = "";
			try{

    $validate = MGoods::on(Auth::user()->db_name)->where('mgoodsname',$request->mgoodsname)->orWhere('mgoodsbarcode',$request->mgoodsbarcode)->where('void',0)->first();
        if ($validate == null) {
        $MGoods = new MGoods($request->all());
        $MGoods->setConnection(Auth::user()->db_name);
        $MGoods->void = 0;
        $MGoods->mgoodsactive = $this->convertBoolean($request->mgoodsactive);
        $MGoods->mgoodscategory = intval($request->mgoodscategory);
        $MGoods->mgoodstype = intval($request->mgoodstype);
        $MGoods->mgoodstaxppn = intval($request->mgoodstaxppn);
        $MGoods->mgoodstaxppnbm = intval($request->mgoodstaxppnbm);
        $MGoods->mgoodssubtype = intval($request->mgoodssubtype);
        $MGoods->mgoodsbranches = $this->convertBoolean($request->mgoodsbranches);
        $MGoods->mgoodsuniquetransaction = $this->convertBoolean($request->mgoodsuniquetransaction);
        $MGoods->mgoodsmultiunit = $this->convertBoolean($request->mgoodsmultiunit);
        $MGoods->mgoodssetmaxdisc = $this->convertBoolean($request->mgoodssetmaxdisc);
        $MGoods->mgoodstaxable = $this->convertBoolean($request->mgoodstaxable);
        $MGoods->mgoodssuppliercode = $request->mgoodssuppliercode;
        $MGoods->save();
        $MGoods->mgoodssuppliername = $MGoods->supplier()->msuppliername;
        $MGoods->save();

        if($request->autogen == "true"){
          $MGoods->autogenproc();
          $MGoods->save();
        }
        $isvalid = $MGoods->doublecheckid();
        if($isvalid){
          return response()->json($MGoods);
        } else {
          $errorInfo = [
            'err',
            'err',
            'Duplicate employee ID'
          ];
          $e = array('errorInfo' => $errorInfo);
          $MGoods->revert_creation();
          return response()->json($e,400);
        }
      }
      else{
        return response()->json('',400);
      }
      }catch(Exception $e){
        return response()->json($e,400);
			}

	}
 public function update(Request $request,$id){
      $mgoods = MGoods::on(Auth::user()->db_name)->where('id',$id)->first();
      $mgoods->update($request->all());
      $mgoods->mgoodsactive = $this->convertBoolean($request->mgoodsactive);
      $mgoods->mgoodsbranches = $this->convertBoolean($request->mgoodsbranches);
      $mgoods->mgoodsuniquetransaction = $this->convertBoolean($request->mgoodsuniquetransaction);
      $mgoods->mgoodsmultiunit = $this->convertint($request->mgoodsmultiunit);
      $mgoods->mgoodssuppliername = $mgoods->supplier()->msuppliername;
      $mgoods->mgoodssetmaxdisc = $this->convertBoolean($request->mgoodssetmaxdisc);
      $mgoods->mgoodstaxable = $this->convertBoolean($request->mgoodstaxable);
      $mgoods->save();
    return response()->json($mgoods);
  }

	public function destroy($id){
		$MGoods = MGoods::on(Auth::user()->db_name)->where('id',$id)->first();
    $MGoods->void = 1;
    $MGoods->save();
    return response()->json();
	}

	  public function gambar(Request $request){

      $validator = Validator::make($request->all(),[
        'gambar' => 'required|max:2000|mimes:png,jpg,jpeg'
      ]);

      if($validator->fails()){
        return response()->json('File harus berupa png atau jpg dengan ukuran < 2MB',403);
      } else {
        $gambar = $request->file('gambar');
        $filename = uniqid().'.'.$gambar->extension();
        $gambar->move('gambar',$filename); //ke public gambar
        $url = url('gambar/'.$filename);
        return response()->json(array('url' => $url));
      }


    }


}
