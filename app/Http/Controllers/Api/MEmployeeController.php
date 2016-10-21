<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use App\MEmployee;
use Exception;
use DB;

class MEmployeeController extends Controller
{
    public function index(){
      $this->iteration = 0;
          $mcategory = MEmployee::where('void', '0')->orderby('created_at','desc')->get();
          return Datatables::of($mcategory)->addColumn('action', function($memployee){

            return '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmemployee('.$memployee->id.')"> <font style="">Lihat</font></a>
            <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmemployee('.$memployee->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
            <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$memployee->id.')">
          <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($memployee){
              $this->iteration++;
              return "<span>".$this->iteration."</span>";
          })->addColumn('akun',function($memployee){
              $this->iteration++;
              return "<span>".$memployee->akun->mcoaname."</span>";
          })
          ->make(true);
    }

    public function store(Request $request){
      $new_empl = "";
      try{
        $new_empl = MEmployee::create($request->all());
        $new_empl->save();
        if($request->autogen == "true"){
          $new_empl->autogenproc();
          $new_empl->save();
        }
        return response()->json($new_empl->memployeeid);
      } catch(Exception $e){
        if($request->autogen == "true"){
          $new_empl->autogenproc();
          $new_empl->save();
          return response()->json($new_empl->memployeeid);
        } else {
          return response()->json($e,400);
        }

      }

    }

    public function update(Request $request, $id){
      try{
        $empl = MEmployee::find($id);
        $empl->update($request->all());
        return response()->json($empl);
      } catch(Exception $e){
        return repsonse()->json($e);
      }
    }

    public function show($id){
      $empl = MEmployee::find($id);
      return response()->json($empl);
    }

    public function destroy($id){
      $empl = MEmployee::find($id);
      $empl->void =1;
      $empl->save();
      return response()->json();
    }
}
