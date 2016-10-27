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

class MGoodsController extends Controller
{

  private function convertBoolean($string_bool){
      if($string_bool == "true"){
        return 1;
      } else {
        return 0;
      }
  }

	public function index(){
		 $this->iteration = 0;
        $MGoods = MGoods::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($MGoods)->addColumn('action', function($MGoods){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmgoods('.$MGoods->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmgoods('.$MGoods->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$MGoods->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($MGoods){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->addColumn('category',function($MGoods){
            return "<span>".$MGoods->category->category_name."</span>";
        })
        ->addColumn('brand',function($MGoods){
            return "<span>".$MGoods->mark->category_name."</span>";
        })
        ->make(true);
	}
	public function show($id){
		$MGoods = MGoods::find($id);
      	return response()->json($MGoods);
	}

    public function store(Request $request){
      $MGoods = "";
			try{
				$MGoods = MGoods::create($request->all());
				$MGoods->void = 0;
        $MGoods->mgoodsactive = $this->convertBoolean($request->mgoodsactive);
        $MGoods->mgoodsbranches = $this->convertBoolean($request->mgoodsbranches);
        $MGoods->mgoodsuniquetransaction = $this->convertBoolean($request->mgoodsuniquetransaction);
				$MGoods->save();
        $MGoods->mgoodssuppliername = $MGoods->supplier->msuppliername;
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
			} catch(Exception $e){
        return response()->json($e,400);
			}

	}
 public function update(Request $request,$id){
      $mgoods = MGoods::find($id);
      $mgoods->update($request->all());
      $mgoods->mgoodsactive = $this->convertBoolean($request->mgoodsactive);
      $mgoods->mgoodsbranches = $this->convertBoolean($request->mgoodsbranches);
      $mgoods->mgoodsuniquetransaction = $this->convertBoolean($request->mgoodsuniquetransaction);
      $mgoods->save();
    return response()->json($mgoods);
  }

	public function destroy($id){
		$MGoods = MGoods::find($id);
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
