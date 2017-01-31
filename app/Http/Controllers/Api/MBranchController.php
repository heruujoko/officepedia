<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MBRANCH;
use Datatables;
use Exception;
use Auth;

class MBranchController extends Controller
{


	public function index(){
		$this->iteration = 0;
        $mbranch = MBRANCH::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mbranch)->addColumn('action', function($mbranch){
            $menus = '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmbranch('.$mbranch->id.')"> <font style="">Lihat</font></a>';

            if(Auth::user()->has_role('U_branch')){
                $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmbranch('.$mbranch->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
            }
            if(Auth::user()->has_role('D_branch')){
                $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mbranch->id.')">
              <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
            }
          return $menus;
        })->addColumn('no',function($mbranch){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
	}
	public function show($id){
		$mbranch = MBRANCH::on(Auth::user()->db_name)->where('id',$id)->first();
      	return response()->json($mbranch);
	}

    public function store(Request $request){
			try{
				$mbranch = new MBRANCH;
				$mbranch->setConnection(Auth::user()->db_name);
				$mbranch->mbranchcode = $request->mbranchcode;
				$mbranch->mbranchname = $request->mbranchname;
				$mbranch->phone = $request->phone;
				$mbranch->city = $request->city;
				$mbranch->person_in_charge = $request->person_in_charge;
				$mbranch->information = $request->information;
				$mbranch->defaultwarehouse = $request->defaultwarehouse;
				$mbranch->void = 0;
				$mbranch->save();
				return response()->json($mbranch);
			} catch(Exception $e){
				dd($e);
				return response()->json($e,400);
			}

	}

	public function update(Request $request,$id){
		try{
			$mbranch = MBRANCH::on(Auth::user()->db_name)->where('id',$id)->first();
			$mbranch->update($request->all());
			return response()->json($mbranch);
		}catch(Exception $e){
			return response()->json($e,400);
		}

	}

	public function destroy($id){
	$mbranch = MBRANCH::find($id);
    DB::table('mbranch')->where('id',$id)->update(['void' => '1']);
    return redirect('admin-nano/cabang#main');
	}


}
