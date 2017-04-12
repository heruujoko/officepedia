<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MDepartement;
use Datatables;
use Exception;
use DB;
use Auth;
use App\Helper\DBHelper;

class MDepartementController extends Controller
{

	public function index(){
		$this->iteration = 0;
        $mdepartement = MDepartement::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mdepartement)->addColumn('action', function($mdepartement){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmdepartement('.$mdepartement->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmdepartement('.$mdepartement->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mdepartement->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($mdepartement){
            $this->iteration++;
            return "<span style=\"float:right\">".$this->iteration."</span>";
        })
        ->make(true);
	}
	public function show($id){
    $mdepartement = MDepartement::on(Auth::user()->db_name)->where('id',$id)->first();
    return response()->json($mdepartement);

	}
	public function store(Request $request){
    try{
        $mdepartement = new MDepartement($request->all());
				$mdepartement->setConnection(Auth::user()->db_name);
        $mdepartement->void = 0;
        $mdepartement->save();
        return response()->json($mdepartement);
      } catch(Exception $e){
        return response()->json($e,400);
      }
	}
	public function update(Request $request,$id){
    try{
	    $mdepartement = MDepartement::on(Auth::user()->db_name)->where('id',$id)->first();
      $mdepartement->update($request->all());
      return response()->json($mdepartement);
    }catch(Exception $e){
      return response()->json($e,400);
    }

	}
	public function destroy($id){
    $mdepartement = MDepartement::on(Auth::user()->db_name)->where('id',$id)->first();
    $mdepartement->void = 1;
    $mdepartement->save();
    return response()->json();
	}



}
