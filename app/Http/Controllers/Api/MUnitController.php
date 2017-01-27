<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Exception;
use DB;
use Datatables;
use App\MUnit;
use Auth;

class MUnitController extends Controller
{
  public function index(){
        $this->iteration = 0;
        $munit = MUnit::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($munit)->addColumn('action', function($munit){
            return $menus = '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmunit('.$munit->id.')"> <font style="">Lihat</font></a>';

            if(Auth::user()->has_role('U_units')){
                $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmunit('.$munit->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
            }
            if(Auth::user()->has_role('D_units')){
                $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$munit->id.')">
              <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>'; 
            }
          return $menus;
      })->addColumn('no',function($munit){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
  }
  public function show($id){
        $munit = MUnit::on(Auth::user()->db_name)->where('id',$id)->first();
        return response()->json($munit);
  }

    public function store(Request $request){
      try{
        $munit = new MUnit($request->all());
        $munit->setConnection(Auth::user()->db_name);
        $munit->void = 0;
        $munit->save();
        return response()->json($munit);
      } catch(Exception $e){
        return response()->json($e,400);
      }

  }

  public function update(Request $request,$id){
    try{
      $munit = MUnit::on(Auth::user()->db_name)->where('id',$id)->first();
      $munit->update($request->all());
      return response()->json($munit);
    }catch(Exception $e){
      return response()->json($e,400);
    }

  }

  public function destroy($id){
    $munit = MUnit::on(Auth::user()->db_name)->where('id',$id)->first();
    $munit->void = 1;
    $munit->save();
    return response()->json();
  }
}
