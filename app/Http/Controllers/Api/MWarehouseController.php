<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MWarehouse;
use Datatables;
use DB;
use Auth;
use App\Helper\DBHelper;
use App\MBRANCH;

class MWarehouseController extends Controller
{


  public function index(){
    $this->iteration = 0;
        $mbrand = MWarehouse::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mbrand)->addColumn('action', function($mbrand){
            $menus = '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmwarehouse('.$mbrand->id.')"> <font style="">Lihat</font></a>';

            if(Auth::user()->has_role('U_warehouse')){
                $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmwarehouse('.$mbrand->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
            }
            if(Auth::user()->has_role('D_warehouse')){
                $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mbrand->id.')">
              <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
            }
          return $menus;
        })->addColumn('no',function($mbrand){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
  }

  public function datalist(){
    //   $warehouses = MWarehouse::on(Auth::user()->db_name)->where('void', '0')
        $default_branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first()->mbranchcode;
        $warehouses = MWarehouse::on(Auth::user()->db_name)->where('void',0)->orderby('created_at','desc')->where('mwarehousebranchid',$default_branch)->get();
        return response()->json($warehouses);
  }

  public function show($id){
    $mbrand = MWarehouse::on(Auth::user()->db_name)->where('id',$id)->first();
        return response()->json($mbrand);
  }

    public function store(Request $request){
      try{
        $mbrand = new MWarehouse($request->all());
        $mbrand->setConnection(Auth::user()->db_name);
        $mbrand->void = 0;
        $mbrand->save();
        return response()->json($mbrand);
      } catch(Exception $e){
        return response()->json($e,400);
      }

  }

  public function update(Request $request,$id){
    try{
      $mbrand = MWarehouse::on(Auth::user()->db_name)->where('id',$id)->first();
      $mbrand->update($request->all());
      return response()->json($mbrand);
    }catch(Exception $e){
      return response()->json($e,400);
    }

  }

  public function destroy($id){
    $mbrand = MWarehouse::on(Auth::user()->db_name)->where('id',$id)->first();
    $mbrand->void = 1;
    $mbrand->save();
    return response()->json();
  }


}
