<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MCOA;
use Datatables;

class MCOAController extends Controller
{

    private $iteration;

    public function index(){
      $mcoa = MCOA::all();
      return Datatables::of($mcoa)->addColumn('action', function($mcoa){
        return '<center><div class="button">
        <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcoa('.$mcoa->id.')"> <font style="">Lihat</font></a>
        <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcoa('.$mcoa->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
        <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mcoa->id.')">
      <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
    })->addColumn('no',function($mcoa){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })->addColumn('type',function($mcoa){
          if($mcoa->mcoatype == 'K'){
            return "Kredit";
          } else {
            return "Debet";
          }
      })
      ->make(true);
    }

    public function show($id){
      $mcoa = MCOA::find($id);
      return response()->json($mcoa);
    }

    public function store(Request $request){
      $mcoa = new MCOA;
      $mcoa->mcoacode = $request->mcoacode;
      $mcoa->mcoaname = $request->mcoaname;
      $mcoa->mcoatype = $request->mcoatype;
      $mcoa->set_parent($request->mcoaparent);
      $mcoa->save();

      return response()->json($mcoa);
    }

    public function update(Request $request,$id){
      $mcoa = MCOA::find($id);
      $mcoa->mcoacode = $request->mcoacode;
      $mcoa->mcoaname = $request->mcoaname;
      $mcoa->mcoatype = $request->mcoatype;
      $mcoa->set_parent($request->mcoaparent);
      $mcoa->save();

      return response()->json($mcoa);
    }

    public function destroy($id){
      $mcoa = MCOA::find($id)->delete();
      return response()->json();
    }
}
