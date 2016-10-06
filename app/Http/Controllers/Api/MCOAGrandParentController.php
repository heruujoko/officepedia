<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Datatables;
use App\MCOAGrandParent;
use Exception;

class MCOAGrandParentController extends Controller
{
    private $iteration =0;

    public function index(){
      $grandparents = MCOAGrandParent::all();
      return Datatables::of($grandparents)->addColumn('action', function($grandparents){
        return '<center><div class="button">
        <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewgrandparent('.$grandparents->id.')"> <font style="">Lihat</font></a>
        <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editgrandparent('.$grandparents->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
        <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$grandparents->id.')">
      <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
      })->addColumn('no',function($grandparents){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })->addColumn('type',function($grandparents){
          if($grandparents->mcoagrandparenttype == 'K'){
            return "Kredit";
          } else {
            return "Debet";
          }
      })
      ->make(true);
    }

    public function store(Request $request){
      try{
          $gp = MCOAGrandParent::create($request->all());
          return response()->json($gp);
      } catch(Exception $e) {
         return response()->json($e,400);
      }

    }

    public function show($id){
      $gp = MCOAGrandParent::find($id);
      return response()->json($gp);
    }

    public function update(Request $request,$id){
      try{
          $gp = MCOAGrandParent::find($id);
          $gp->update($request->all());
          return response()->json($gp);
      } catch(Exception $e){
          return response()->json($e,400);
      }

    }

    public function destroy($id){
      $gp = MCOAGrandParent::find($id);
      $gp->void = 1;
      $gp->save();
      return response()->json();
    }

    public function lists(){
        $parents = MCOAGrandParent::all();
        $select_str = "";
        foreach($parents as $gp) {
            $select_str .= "<option value=\"" . $gp->mcoagrandparentcode . "\">" . $gp->mcoagrandparentname . "</option>";
        }
        return response()->json($select_str);
    }
}
