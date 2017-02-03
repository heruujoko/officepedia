<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use Auth;
use Datatables;

class RoleController extends Controller
{
    private $iteration;

    public function index(){
      $this->iteration = 0;

      $mtax = Role::on(Auth::user()->db_name)->where('void',0)->orderby('created_at','desc')->get();
      return Datatables::of($mtax)->addColumn('action', function($role){

          if($role->id == 1){
              return '<center><div class="button">
              <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewrole('.$role->id.')"> <font style="">Lihat</font></a>
              <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editrole('.$role->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
          } else {
              return '<center><div class="button">
              <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewrole('.$role->id.')"> <font style="">Lihat</font></a>
              <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editrole('.$role->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
              <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$role->id.')">
            <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
          }
    })->addColumn('no',function($mtax){
          $this->iteration++;
          return "<span style=\"float:right\">".$this->iteration."</span>";
      })
      ->make(true);
    }

    public function store(Request $request){

        $newrole = (new Role($request->all()))->setConnection(Auth::user()->db_name);
        $newrole->save();

        return response()->json($newrole);

    }

    public function update(Request $request,$id){
        $role = Role::on(Auth::user()->db_name)->where('id',$id)->where('void',0)->first();
        $role->update($request->all());
        return response()->json($role);
    }

    public function show($id){
        $role = Role::on(Auth::user()->db_name)->where('id',$id)->where('void',0)->first()->toArray();

        array_walk($role,function(&$item,$key){
            if($item == 1 && ($key != "name" && $key != "id")){
                $item = true;
            } else if($item == 0 && ($key != "name" && $key != "id")) {
                $item = false;
            } else {

            }
        });

        return response()->json($role);
    }

    public function destroy($id){
        $role = Role::on(Auth::user()->db_name)->where('id',$id)->where('void',0)->first();
        $role->void = 1;
        $role->save();
        return response()->json();
    }
}
