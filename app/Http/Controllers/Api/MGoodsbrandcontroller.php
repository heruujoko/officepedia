<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MGoodsbrand;
use Datatables;
use Exception;
use DB;

class MGoodsbrandController extends Controller
{


	public function index(){
		$this->iteration = 0;
        $mbrand = MGoodsbrand::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mbrand)->addColumn('action', function($mbrand){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmgoodsbrand('.$mbrand->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmgoodsbrand('.$mbrand->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mbrand->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($mbrand){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
	}
	public function show($id){
		$mbrand = MGoodsbrand::find($id);
      	return response()->json($mbrand);
	}

    public function store(Request $request){
			try{
				$mbrand = MGoodsbrand::create($request->all());
				$mbrand->void = 0;
				$mbrand->save();
				return response()->json($mbrand);
			} catch(Exception $e){
				return response()->json($e,400);
			}

	}

	public function update(Request $request,$id){
		try{
			$mbrand = MGoodsbrand::find($id);
			$mbrand->update($request->all());
			return response()->json($mbrand);
		}catch(Exception $e){
			return response()->json($e,400);
		}

	}

	public function destroy($id){
	$mbrand = MGoodsbrand::find($id);
    DB::table('mgoodsbrand')->where('id',$id)->update(['void' => '1']);
    return response()->json();
	}


}
