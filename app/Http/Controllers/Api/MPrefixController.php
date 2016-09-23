<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MPrefix;
use Datatables;
class MPrefixController extends Controller
{
    private $iteration;

    public function index(){
      $prefix = MPrefix::all();
      return Datatables::of($prefix)->addColumn('action', function($prefix){
        return '<center><div class="button">
        <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewprefix('.$prefix->id.')"> <font style="">Lihat</font></a>
        <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editprefix('.$prefix->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
        <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$prefix->id.')">
      <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
    })->addColumn('no',function($prefix){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })->make(true);
    }

    public function show($id){
      $p = MPrefix::find($id);
      return response()->json($p);
    }

    public function store(Request $request){
      $p = MPrefix::create($request->all());
      return response()->json($p);
    }

    public function update(Request $request,$id){
      $p = MPrefix::find($id);
      $p->update($request->all());
      return response()->json($p);
    }

    public function destroy($id){
      $p = MPrefix::find($id)->delete();
      return response()->json();
    }
}
