<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MGoods;
use Datatables;
use Exception;

class MGoodsController extends Controller
{


	public function index(){
		 $this->iteration = 0;
        $MGoods = MGoods::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($MGoods)->addColumn('action', function($MGoods){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewMGoods('.$MGoods->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editMGoods('.$MGoods->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$MGoods->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($MGoods){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
	}
	public function show($id){
		$MGoods = MGoods::find($id);
      	return response()->json($MGoods);
	}

    public function store(Request $request){
			try{
				$MGoods = MGoods::create($request->all());
				$MGoods->void = 0;
				$MGoods->save();
				return response()->json($MGoods);
			} catch(Exception $e){
				return response()->json($e,400);
			}

	}

	public function update(Request $request,$id){
		try{
			$MGoods = MGoods::find($id);
			$MGoods->update($request->all());
			return response()->json($MGoods);
		}catch(Exception $e){
			return response()->json($e,400);
		}

	}

	public function destroy($id){
		$MGoods = MGoods::find($id);
    DB::table('MGoods')->where('id',$id)->update(['void' => '1']);
    return redirect('admin-nano/cabang#main');
	}


}
