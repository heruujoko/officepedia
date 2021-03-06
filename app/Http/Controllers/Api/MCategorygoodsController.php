<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MCategorygoods;
use Datatables;
use Exception;
use DB;

class MCategorygoodsController extends Controller
{

	public function index(){
		$this->iteration = 0;
        $mcategory = MCategorygoods::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mcategory)->addColumn('action', function($mcategory){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcategory('.$mcategory->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcategory('.$mcategory->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mcategory->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($mcategorygoods){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
	}
	public function show($id){
    $mcategory = MCategorygoods::find($id);
    return response()->json($mcategory);

	}
	public function store(Request $request){
    try{
        $mcategory = MCategorygoods::create($request->all());
        $mcategory->void = 0;
        $mcategory->save();
        return response()->json($mcategory);
      } catch(Exception $e){
        return response()->json($e,400);
      }
	}
	public function update(Request $request,$id){
    try{
      $mcategory = MCategorygoods::find($id);
      $mcategory->update($request->all());
      return response()->json($mcategory);
    }catch(Exception $e){
      return response()->json($e,400);
    }

	}
	public function destroy($id){
    $mcategory = MCategorygoods::find($id);
    DB::table('mcategorygoods')->where('id',$id)->update(['void' => '1']);
    return response()->json();
	}



}