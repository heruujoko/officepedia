<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MBRANCH;
use Datatables;

class MBranchController extends Controller
{


	public function index(){
		 $this->iteration = 0;
        $mbranch = MBRANCH::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mbranch)->addColumn('action', function($mbranch){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmbranch('.$mbranch->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmbranch('.$mbranch->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mbranch->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($mbranch){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
	}
	public function show($id){
		$mbranch = MBRANCH::find($id);
      	return response()->json($mbranch);
	}

    public function store(Request $request){
    	$mbranch = MBRANCH::create($request->all());
    	$mbranch->void = 0;
    	$mbranch->save();
     	return response()->json($mbranch);
	}

	public function update(Request $request,$id){
		$mbranch = MBRANCH::find($id);
		$mbranch->update($request->all());
		return response()->json($mbranch);
	}

	public function destroy($id){
		$mbranch = MBRANCH::find($id);
    DB::table('mbranch')->where('id',$id)->update(['void' => '1']);
    return redirect('admin-nano/cabang#main');
	}


}
