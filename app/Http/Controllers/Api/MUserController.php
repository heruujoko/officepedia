<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MUser;
use Datatables;
use DB;
use Auth;
use App\Helper\DBHelper;
use App\User;
use App\UserBranch;

class MUserController extends Controller
{

  public function index(){
    $this->iteration = 0;
        $mbrand = MUser::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mbrand)->addColumn('action', function($mbrand){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmuser('.$mbrand->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmuser('.$mbrand->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mbrand->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($mbrand){
            $this->iteration++;
            return "<span style=\"float:right\">".$this->iteration."</span>";
        })
        ->make(true);
  }

  public function datalist(){
      $warehouses = MUser::on(Auth::user()->db_name)->where('void', '0')->orderby('created_at','desc')->get();
      return response()->json($warehouses);
  }

  public function show($id){
    $mbrand = MUser::on(Auth::user()->db_name)->where('id',$id)->first();

    $user = User::where('email',$mbrand->museremail)->first();

    $mbrand['branches'] = UserBranch::on(Auth::user()->db_name)->where('userid',$user->id)->get();

    return response()->json($mbrand);
  }

    public function store(Request $request){
      try{

        $crypt = bcrypt($request->muserpass);

        $mbrand = new MUser($request->all());
        $mbrand->setConnection(Auth::user()->db_name);
        $mbrand->void = 0;
        $mbrand->save();
        $mbrand->muserpass = $crypt;
        $mbrand->save();

        // save to main DB

        $user = new User;
        $user->name = $request->musername;
        $user->email = $request->museremail;
        $user->password = $crypt;
        $user->db_alias = Auth::user()->db_alias;
        $user->db_name = Auth::user()->db_name;
        $user->save();

        foreach($request->muserbranches as $branch_id){
            $branchuser = new UserBranch;
            $branchuser->setConnection(Auth::user()->db_name);
            $branchuser->userid = $user->id;
            $branchuser->branchid = $branch_id;
            $branchuser->save();
        }

        return response()->json($mbrand);
      } catch(Exception $e){
        return response()->json($e,400);
      }

  }

  public function update(Request $request,$id){
    try{
      $mbrand = MUser::on(Auth::user()->db_name)->where('id',$id)->first();
      $user = User::where('email',$mbrand->museremail)->first();
      $crypt = "";
      if($request->muserpass != ""){
        $crypt = bcrypt($request->muserpass);
      }

      $mbrand->update($request->except('muserpass'));
      $user->name = $request->musername;
      $user->email = $request->museremail;
      if($request->muserpass != ""){
        $user->password = $crypt;
      }
      $user->save();

      $old_branch_role = UserBranch::on(Auth::user()->db_name)->where('userid',$user->id)->get();
      foreach($old_branch_role as $r){
          $r->delete();
      }

      foreach($request->muserbranches as $branch_id){
          $branchuser = new UserBranch;
          $branchuser->setConnection(Auth::user()->db_name);
          $branchuser->userid = $user->id;
          $branchuser->branchid = $branch_id;
          $branchuser->save();
      }

      return response()->json($mbrand);
    }catch(Exception $e){
      return response()->json($e,400);
    }

  }

  public function destroy($id){
    $mbrand = MUser::on(Auth::user()->db_name)->where('id',$id)->first();
    $user = User::where('email',$mbrand->museremail)->first();
    $user->delete();
    $mbrand->void = 1;
    $mbrand->save();
    return response()->json();
  }


}
