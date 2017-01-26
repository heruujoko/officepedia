<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserBranch;
use App\MBRANCH;
use Auth;
use App\User;
class ProfileController extends Controller
{
    public function mybranch(){
        $brs = UserBranch::on(Auth::user()->db_name)->where('userid',Auth::user()->id)->get();
        $branch_ids = [];
        foreach($brs as $b){
            array_push($branch_ids,$b->branchid);
        }

        $branches = MBRANCH::on(Auth::user()->db_name)->whereIn('id',$branch_ids)->get();
        return response()->json($branches);
    }

    public function default_branch(){
        $branch = "";
        if(Auth::user()->defaultbranch != ""){
            $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();
        }
        return response()->json($branch);
    }

    public function update_default_branch(Request $request){
        $user = User::find(Auth::user()->id);
        $user->defaultbranch = $request->branch;
        $user->save();
        return response()->json($user);
    }
}
