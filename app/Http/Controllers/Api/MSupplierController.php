<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MSupplier;
use App\MPrefix;
use Datatables;
use DB;
use App\MConfig;
class MSupplierController extends Controller
{
	public function index(){
		 $this->iteration = 0;
        $msupplier = MSupplier::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($msupplier)->addColumn('action', function($msupplier){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmsupplier('.$msupplier->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmsupplier('.$msupplier->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$msupplier->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($msupplier){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })->addColumn('akun',function($msupplier){
            return $msupplier->akun->mcoaname;
        })
        ->make(true);
}

  public function show($id){
    $msupplier = MSupplier::find($id);
    return response()->json($msupplier);
  }

  public function update(Request $request,$id){
      $new_cust = MSupplier::find($id);
			$new_cust->update($request->all());
    return response()->json($new_cust);
  }

	public function store(Request $request){
		try{
			$new_cust = MSupplier::create($request->all());
			$new_cust->void = 0;
			$new_cust->save();
			if ($request->autogen == 'true') {
				$new_cust->autogenproc();
			}
			$new_cust->save();
      return response()->json($new_cust);
		} catch(Exception $e){
			if ($request->autogen == 'true') {
				$new_cust->autogenproc();
				$new_cust->save();
	      return response()->json($new_cust);
			} else {
				return response()->json($e,400);
			}
		}
	}


   public function destroy($id){
    $mbranch = MSupplier::find($id);
    DB::table('msupplier')->where('id',$id)->update(['void' => '1']);
    return response()->json();
    }

}
