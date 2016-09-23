<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Datatables;
use App\MCOAParent;
use App\MCOAGrandParent;

class MCOAParentController extends Controller
{
    private $iteration;

    public function index(){
      $parents = MCOAParent::all();
      return Datatables::of($parents)->addColumn('action', function($parents){
        return '<center><div class="button">
        <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewparent('.$parents->id.')"> <font style="">Lihat</font></a>
        <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editparent('.$parents->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
        <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$parents->id.')">
      <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
    })->addColumn('no',function($parents){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })->addColumn('type',function($parents){
          if($parents->mcoaparenttype == 'K'){
            return "Kredit";
          } else {
            return "Debet";
          }
      })
      ->make(true);
    }

    public function show($id){
      $parent = MCOAParent::find($id);
      return response()->json($parent);
    }

    public function store(Request $request){
      $new_parent = new MCOAParent;
      $new_parent->mcoaparentcode = $request->mcoaparentcode;
      $new_parent->mcoaparentname = $request->mcoaparentname;
      $new_parent->save();
      $gp = MCOAGrandParent::findCode($request->mcoagrandparent);
      $new_parent->mcoagrandparentcode = $gp->mcoagrandparentcode;
      $new_parent->mcoagrandparentname = $gp->mcoagrandparentname;
      $new_parent->mcoaparenttype = $gp->mcoagrandparenttype;
      $new_parent->save();
      return response()->json($new_parent);
    }

    public function update(Request $request,$id){
      $update_parent = MCOAParent::find($id);
      $update_parent->mcoaparentcode = $request->mcoaparentcode;
      $update_parent->mcoaparentname = $request->mcoaparentname;
      $update_parent->save();
      $gp = MCOAGrandParent::findCode($request->mcoagrandparent);
      $update_parent->mcoagrandparentcode = $gp->mcoagrandparentcode;
      $update_parent->mcoagrandparentname = $gp->mcoagrandparentname;
      $update_parent->mcoaparenttype = $gp->mcoagrandparenttype;
      $update_parent->save();
      return response()->json($update_parent);
    }

    public function destroy($id){
      $p = MCOAParent::find($id)->delete();
      return response()->json();
    }
}
