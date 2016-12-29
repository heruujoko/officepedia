<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MCOA;
use App\MCOAGrandParent;
use Datatables;
use Exception;
use App\MConfig;
use Auth;
use App\Helper\DBHelper;

class MCOAController extends Controller
{

    private $iteration;
    private $round;
    private $separator;

    public function index(){
      DBHelper::configureConnection(Auth::user()->db_alias);
      $mcoa = collect();
      $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $this->round = $config->msysgenrounddec;
      $this->separator = $config->msysnumseparator;
      $gp = MCOAGrandParent::on(Auth::user()->db_name)->get();
      foreach ($gp as $g) {
        $mcoa->push($g);
        foreach($g->childs() as $p ){
          $mcoa->push($p);
          foreach($p->childs() as $c){
            $mcoa->push($c);
          }
        }
      }
      return Datatables::of($mcoa)->addColumn('action', function($mcoa){
        if($mcoa->mcoacode){
          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcoa('.$mcoa->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcoa('.$mcoa->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mcoa->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        } else if($mcoa->mcoaparentcode){
          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcoaparent('.$mcoa->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcoaparent('.$mcoa->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdeleteparent('.$mcoa->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        } else {
          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcoagp('.$mcoa->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcoagp('.$mcoa->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdeletegp('.$mcoa->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        }

    })->addColumn('no',function($mcoa){
          $this->iteration++;
          return "<span>".$this->iteration."</span>";
      })->addColumn('type',function($mcoa){
          if($mcoa->mcoatype == 'K'){
            return "Kredit";
          } else {
            return "Debet";
          }
      })->addColumn('code',function($mcoa){
          if($mcoa->mcoacode){
            return '<span> ------ '.$mcoa->mcoacode.'</span>';
          } else if($mcoa->mcoaparentcode) {
            return '<span> --- <span style="font-weight:bold;">'.$mcoa->mcoaparentcode.'</span></span>';
          } else {
            return '<span><span style="font-weight:bold;">'.$mcoa->mcoagrandparentcode.'</span></span>';
          }
      })->addColumn('spanname',function($mcoa){
          if($mcoa->mcoaname){
            return '<span> ------ '.$mcoa->mcoaname.'</span>';
          } else if($mcoa->mcoaparentname) {
            return '<span> --- <span style="font-weight:bold;">'.$mcoa->mcoaparentname.'</span></span>';
          } else {
            return '<span><span style="font-weight:bold;">'.$mcoa->mcoagrandparentname.'</span></span>';
          }
      })->addColumn('name',function($mcoa){
          if($mcoa->mcoaname){
            return $mcoa->mcoaname;
          } else if($mcoa->mcoaparentname) {
            return $mcoa->mcoaparentname;
          } else {
            return $mcoa->mcoagrandparentname;
          }
      })
      ->addColumn('saldoright',function($mcoa){
          $decimals = $this->round;
          $dec_point = $this->separator;
          if($dec_point == ","){
            $thousands_sep = ".";
          } else {
            $thousands_sep = ",";
          }
          $formatted_saldo = number_format($mcoa->saldo,$decimals,$dec_point,$thousands_sep);
          return "<span style=\"float:right\">".$formatted_saldo."</span>";
      })
      ->make(true);
    }

    public function datalist(){
        // $mcoa = MCOA::on(Auth::user()->db_name)->get();
        $mcoa = MCOA::on(Auth::user()->db_name)->where('mcoaparentcode','1101.00')->orWhere('mcoaparentcode','1102.00')->get();
        return response()->json($mcoa);
    }

    public function datalistledger(){
        $mcoa = MCOA::on(Auth::user()->db_name)->where('mcoaparentcode','1101.00')->orWhere('mcoaparentcode','1102.00')->orWhere('mcoaparentcode','2101.00')->orWhere('mcoaparentcode','1103.00')->get();
        return response()->json($mcoa);
    }

    public function show($id){
      DBHelper::configureConnection(Auth::user()->db_alias);
      $mcoa = MCOA::on(Auth::user()->db_name)->where('id',$id)->first();
      return response()->json($mcoa);
    }

    public function store(Request $request){
      DBHelper::configureConnection(Auth::user()->db_alias);
      try{
          $mcoa = new MCOA;
          $mcoa->setConnection(Auth::user()->db_name);
          $mcoa->mcoacode = $request->mcoacode;
          $mcoa->mcoaname = $request->mcoaname;
          $mcoa->mcoatype = $request->mcoatype;
          $mcoa->set_parent($request->mcoaparent);
          $mcoa->save();
          if($request->automcoacode == "true"){
            $mcoa->mcoacode = $mcoa->auto_code();
          }
          $mcoa->save();
          return response()->json($mcoa);
      } catch(Exception $e){
          return response()->json($e,400);
      }
    }

    public function update(Request $request,$id){
      DBHelper::configureConnection(Auth::user()->db_alias);
      try{
          $mcoa = MCOA::on(Auth::user()->db_name)->where('id',$id)->first();
          $mcoa->setConnection(Auth::user()->db_name);
          $mcoa->mcoacode = $request->mcoacode;
          $mcoa->mcoaname = $request->mcoaname;
          $mcoa->mcoatype = $request->mcoatype;
          $mcoa->set_parent($request->mcoaparent);
          $mcoa->save();
          return response()->json($mcoa);
      } catch(Exception $e){
          return response()->json($e,400);
      }
    }

    public function destroy($id){
      DBHelper::configureConnection(Auth::user()->db_alias);
      $mcoa = MCOA::on(Auth::user()->db_name)->where('id',$id)->first();
      $mcoa->void = 1;
      $mcoa->save();
      return response()->json();
    }

    public function tree(){
      $tree_string = '<ul role="tree">';
      $gp = MCOAGrandParent::all();
      foreach($gp as $grand){
        $tree_string .= '<li class="parent_li" role="treeitem">
          <span title="Collapse this branch"><i class="fa fa-lg fa-folder-open"></i> <b>'.$grand->mcoagrandparentcode.'</b> '.$grand->mcoagrandparentname.'</span>
          <ul role="group">';
          foreach ($grand->childs() as $parent) {
            $tree_string .= '<li class="parent_li" role="treeitem">
              <span title="Collapse this branch"><i class="fa fa-lg fa-plus-circle"></i> <b>'.$parent->mcoaparentcode.'</b>'.$parent->mcoaparentname.'</span>
              <ul role="group">
                <li>
                  <span title="Collapse this branch" class="addtree" onclick="addcoa(\''.$parent->mcoaparentcode.'\',\''.$parent->mcoaparenttype.'\')"><i class="fa fa-lg fa-plus-circle"></i> <b>Add New</b></span>
                </li>';
            foreach ($parent->childs() as $coa) {
              $tree_string .= '<li>
                <span title="Collapse this branch"><i class="fa fa-lg fa-plus-circle"></i> <b>'.$coa->mcoacode.'</b> '.$coa->mcoaname.'</span>
                <div class="btn-group">
                  <button class="btn btn-default dropdown-toggle btn-tree" data-toggle="dropdown" aria-expanded="false">
                    Action <i class="fa fa-caret-down"></i>
                  </button>
                  <ul class="dropdown-menu treemenu">
                    <li>
                      <a onclick="viewmcoa('.$coa->id.')">View</a>
                    </li>
                    <li>
                      <a onclick="editmcoa('.$coa->id.')">Edit</a>
                    </li>
                    <li>
                      <a onclick="popupdelete('.$coa->id.')">Delete</a>
                    </li>
                  </ul>
                </div>
              </li>';
            }
            $tree_string .= "</ul></li>";
          }
          $tree_string .= "</ul></li>";
      }
      $tree_string .= "</ul>";
      return response()->json($tree_string);
    }
}
