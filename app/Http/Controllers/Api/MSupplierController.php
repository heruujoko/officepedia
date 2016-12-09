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
use Auth;
use App\Helper\DBHelper;

class MSupplierController extends Controller
{
	public function index(){
		 $this->iteration = 0;
        $msupplier = MSupplier::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($msupplier)->addColumn('action', function($msupplier){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmsupplier('.$msupplier->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmsupplier('.$msupplier->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$msupplier->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($msupplier){
            $this->iteration++;
            return "<span style=\"float:right\">".$this->iteration."</span>";
        })->addColumn('akun',function($msupplier){
            return $msupplier->akun()->mcoaname;
        })->addColumn('category',function($msupplier){
						return $msupplier->category()->category_name;
				})
        ->make(true);
}

    public function datalist(){
        $suppliers = MSupplier::on(Auth::user()->db_name)->get();
        return response()->json($suppliers);
    }

  public function show($id){
    $msupplier = MSupplier::on(Auth::user()->db_name)->where('id',$id)->first();
    return response()->json($msupplier);
  }

  public function update(Request $request,$id){
      $new_cust = MSupplier::on(Auth::user()->db_name)->where('id',$id)->first();
	$new_cust->update($request->all());
    return response()->json($new_cust);
  }

	public function store(Request $request){
		try{
			$new_cust = new MSupplier($request->all());
			$new_cust->setConnection(Auth::user()->db_name);
			$new_cust->void = 0;
			$new_cust->save();
			if ($request->autogen == 'true') {
				$new_cust->autogenproc();
			}
			$new_cust->save();
			$isvalid = $new_cust->doublecheckid();
			if($isvalid){
				return response()->json($request->autogen);
			} else {
				$errorInfo = [
					'err',
					'err',
					'Duplicate supplier ID'
				];
				$e = array('errorInfo' => $errorInfo);
				$new_cust->revert_creation();
				return response()->json($e,400);
			}
		} catch(Exception $e){
			return response()->json($e,400);
		}
	}


   public function destroy($id){
    $mbranch = MSupplier::on(Auth::user()->db_name)->where('id',$id)->first();
    $mbranch->void = 1;
		$mbranch->save();
    return response()->json();
    }

}
