<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MCUSTOMER;
use App\MPrefix;
use Datatables;
use DB;
use App\MConfig;

class MCustomerController extends Controller
{
	public function index(){
		 $this->iteration = 0;
        $mcustomer = MCUSTOMER::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mcustomer)->addColumn('action', function($mcustomer){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcustomer('.$mcustomer->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcustomer('.$mcustomer->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mcustomer->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($mcustomer){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })->addColumn('akun',function($mcustomer){
            return $mcustomer->akun->mcoaname;
        })
        ->make(true);
}

  public function show($id){
    $mcustomer = MCUSTOMER::find($id);
    return response()->json($mcustomer);
  }

  public function update(Request $request,$id){
      $new_cust = MCUSTOMER::find($id);
			$new_cust->update($request->all());
    return response()->json($new_cust);
  }

	public function store(Request $request){
		try{
			$new_cust = MCUSTOMER::create($request->all());
			$new_cust->save();
			if ($request->autogen == 'true') {
				$new_cust->autogenproc();
			}
			$new_cust->void = 0;
			$new_cust->save();
			return response()->json($new_cust);
		} catch(Exception $e){
			if ($request->autogen == 'true') {
				$new_cust->autogenproc();
				$new_empl->save();
				return response()->json($new_empl);
			}
			return response()->json($e,400);
		}


	}


   public function destroy($id){
    $mbranch = MCUSTOMER::find($id);
    DB::table('mcustomer')->where('id',$id)->update(['void' => '1']);
    return response()->json();
    }

}
