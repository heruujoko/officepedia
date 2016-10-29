<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MCOA;
use App\MCOAParent;
use Datatables;
use Exception;
use App\MConfig;

class CashBankListController extends Controller
{
    private $iteration;
    private $round;
    private $separator;

    public function cash(){
      $config = MConfig::find(1);
      $this->round = $config->msysgenrounddec;
      $this->separator = $config->msysnumseparator;
      $kas = MCOA::where('mcoaparentcode','1101.00')->get();
      return Datatables::of($kas)->addColumn('action', function($kas){
        return '<center><div class="button">
        <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="edit_kas('.$kas->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
        <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$kas->id.')">
      <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
    })->addColumn('no',function($parents){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })->addColumn('rightsaldo',function($kas){
            $decimals = $this->round;
            $dec_point = $this->separator;
            if($dec_point == ","){
              $thousands_sep = ".";
            } else {
              $thousands_sep = ",";
            }
            $formatted_saldo = number_format($kas->saldo,$decimals,$dec_point,$thousands_sep);
            return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })
      ->make(true);
    }

    public function bank(){
      $config = MConfig::find(1);
      $this->round = $config->msysgenrounddec;
      $this->separator = $config->msysnumseparator;
      $kas = MCOA::where('mcoaparentcode','1102.00')->get();
      return Datatables::of($kas)->addColumn('action', function($kas){
        return '<center><div class="button">
        <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="edit_bank('.$kas->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
        <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$kas->id.')">
      <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
    })->addColumn('no',function($parents){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })->addColumn('rightsaldo',function($kas){
        $decimals = $this->round;
        $dec_point = $this->separator;
        if($dec_point == ","){
          $thousands_sep = ".";
        } else {
          $thousands_sep = ",";
        }
        $formatted_saldo = number_format($kas->saldo,$decimals,$dec_point,$thousands_sep);
        return "<span style=\"float:right\">".$formatted_saldo."</span>";
        })
      ->make(true);
    }

    public function add_cash(Request $request){
      $parent = MCOAParent::where('mcoaparentcode','1101.00')->first();
      try{
          $mcoa = new MCOA;
          $mcoa->mcoacode = "";
          $mcoa->mcoaname = $request->mcoaname;
          $mcoa->mcoatype = $parent->mcoaparenttype;
          $mcoa->set_parent("1101.00");
          $mcoa->save();
          $mcoa->mcoacode = $mcoa->auto_code();
          $mcoa->save();
          return response()->json($mcoa);
      } catch(Exception $e){
          return response()->json($e,400);
      }
    }

    public function update_cash(Request $request,$id){
      try{
        $mcoa = MCOA::find($id);
        $mcoa->mcoaname = $request->mcoaname;
        $mcoa->save();
        return response()->json($mcoa);
      } catch(Exception $e){
        return response()->json($e);
      }

    }

    public function add_bank(Request $request){
      $parent = MCOAParent::where('mcoaparentcode','1102.00')->first();
      try{
          $mcoa = new MCOA;
          $mcoa->mcoacode = "";
          $mcoa->mcoaname = $request->mcoaname;
          $mcoa->mcoatype = $parent->mcoaparenttype;
          $mcoa->set_parent("1102.00");
          $mcoa->save();
          $mcoa->mcoacode = $mcoa->auto_code();
          $mcoa->save();
          return response()->json($mcoa);
      } catch(Exception $e){
          return response()->json($e,400);
      }
    }

    public function update_bank(Request $request,$id){
      try{
        $mcoa = MCOA::find($id);
        $mcoa->mcoaname = $request->mcoaname;
        $mcoa->save();
        return response()->json($mcoa);
      } catch(Exception $e){
        return response()->json($e);
      }
    }

    public function total($code){
      $config = MConfig::find(1);
      $this->round = $config->msysgenrounddec;
      $this->separator = $config->msysnumseparator;
      $decimals = $this->round;
      $dec_point = $this->separator;
      if($dec_point == ","){
        $thousands_sep = ".";
      } else {
        $thousands_sep = ",";
      }
      $total = 0;
      $akun = MCOA::where('mcoaparentcode',$code)->get();
      foreach($akun as $ak){
        $total += $ak->saldo;
      }
      $total = number_format($total,$decimals,$dec_point,$thousands_sep);
      return response()->json($total);
    }

    public function grand_total(){
      $config = MConfig::find(1);
      $this->round = $config->msysgenrounddec;
      $this->separator = $config->msysnumseparator;
      $decimals = $this->round;
      $dec_point = $this->separator;
      if($dec_point == ","){
        $thousands_sep = ".";
      } else {
        $thousands_sep = ",";
      }
      $total = 0;
      $akun = MCOA::where('mcoaparentcode',"1101.00")->orWhere('mcoaparentcode','1102.00')->get();
      foreach($akun as $ak){
        $total += $ak->saldo;
      }
      $total = number_format($total,$decimals,$dec_point,$thousands_sep);
      return response()->json($total);
    }
}
