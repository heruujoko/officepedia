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
use Auth;
use App\Helper\DBHelper;

class MCustomerController extends Controller
{
	public function index(){
		 $this->iteration = 0;
        $mcustomer = MCUSTOMER::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
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
            return $mcustomer->akun();
        })->addColumn('category',function($mcustomer){
            return $mcustomer->categories()->category_name;
        })
        ->make(true);
}

  public function show($id){
    $mcustomer = MCUSTOMER::on(Auth::user()->db_name)->where('id',$id)->first();
    return response()->json($mcustomer);
  }

  public function update(Request $request,$id){
      $new_cust = MCUSTOMER::on(Auth::user()->db_name)->where('id',$id)->first();
			$new_cust->update($request->all());
    return response()->json($new_cust);
  }

	public function store(Request $request){
		try{
			$new_cust = new MCUSTOMER($request->all());
			$new_cust->setConnection(Auth::user()->db_name);
			$new_cust->save();
			if ($request->autogen == 'true') {
				$new_cust->autogenproc();
			}
			$new_cust->void = 0;
			$new_cust->save();

			// doublecheck

			$isvalid = $new_cust->doublecheckid();
			if($isvalid){
				return response()->json($new_cust);
			} else {
				$errorInfo = [
					'err',
					'err',
					'Duplicate customer ID'
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
    $mbranch = MCUSTOMER::on(Auth::user()->db_name)->where('id',$id)->first();
    $mbranch->void = 1;
	$mbranch->save();
    return response()->json();
  }

	public function datalist(){
		$mcustomers = MCUSTOMER::on(Auth::user()->db_name)->get();
		return response()->json($mcustomers);
	}

}
