<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use Exception;
use DB;
use App\MEmployeeLevel;
use Auth;

class MEmployeeLevelController extends Controller
{
  public function index(){
    $this->iteration = 0;
        $mcategory = MEmployeeLevel::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mcategory)->addColumn('action', function($mcategory){
            $menus = '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcategory('.$mcategory->id.')"> <font style="">Lihat</font></a>';

            if(Auth::user()->has_role('U_employeelevel')){
                $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcategory('.$mcategory->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
            }
            if(Auth::user()->has_role('D_employeelevel')){
                $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mcategory->id.')">
              <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
            }
          return $menus;
        })->addColumn('no',function($mcategorysupplier){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
  }
  public function show($id){
    $mcategory = MEmployeeLevel::on(Auth::user()->db_name)->where('id',$id)->first();
    return response()->json($mcategory);

  }
  public function store(Request $request){
    try{
        $mcategory = new MEmployeeLevel($request->all());
        $mcategory->setConnection(Auth::user()->db_name);
        $mcategory->void = 0;
        $mcategory->save();
        return response()->json($mcategory);
      } catch(Exception $e){
        return response()->json($e,400);
      }
  }
  public function update(Request $request,$id){
    try{
      $mcategory = MEmployeeLevel::on(Auth::user()->db_name)->where('id',$id)->first();
      $mcategory->update($request->all());
      return response()->json($mcategory);
    }catch(Exception $e){
      return response()->json($e,400);
    }

  }
  public function destroy($id){
    $level = MEmployeeLevel::on(Auth::user()->db_name)->where('id',$id)->first();
    // DB::table('memployeelevel')->where('id',$id)->update(['void' => '1']);
    $level->void = 1;
    $level->save();
    return response()->json();
  }
}
