<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MBRANCH;
use Datatables;

class MBranchController extends Controller
{

   
    public function store(Request $request){
    $p = MBRANCH::create($request->all());
    $p->void = 0;
    $p->save();
     return response()->json($p);


    }

}
