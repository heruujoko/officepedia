<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use Exception;
use App\MTax;

class MTaxController extends Controller
{
    private $iteration;

    public function index(){
      $this->iteration = 0;

      $mtax = MTax::where('void',0)->orderby('created_at','desc')->get();
      return Datatables::of($mtax)->addColumn('action', function($mtax){

        return '<center><div class="button">
        <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmtax('.$mtax->id.')"> <font style="">Lihat</font></a>
        <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmtax('.$mtax->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
        <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mtax->id.')">
      <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
    })->addColumn('no',function($mtax){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })->addColumn('percent',function($mtax){
          return "<span>".$mtax->mtaxtpercentage."% </span>";
      })
      ->make(true);
    }

    public function show($id){
      $mtax = MTax::find($id);
      return response()->json($mtax);

  	}

    public function store(Request $request){
      try{
          $mtax = Mtax::create($request->all());
          $mtax->void = 0;
          $mtax->save();
          return response()->json($mtax);
        } catch(Exception $e){
          return response()->json($e,400);
        }
  	}
  	public function update(Request $request,$id){
      try{
        $mtax = Mtax::find($id);
        $mtax->update($request->all());
        return response()->json($mtax);
      }catch(Exception $e){
        return response()->json($e,400);
      }

  	}

    public function destroy($id){
      $mtax = MTax::find($id);
      $mtax->void = 1;
      $mtax->save();
      return response()->json();
    }
}