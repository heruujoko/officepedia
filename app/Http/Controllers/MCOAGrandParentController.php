<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class MCOAGrandParentController extends Controller {
    public function index(){
      $grandparents = DB::table('mcoagrandparent')->orderby('created_at','desc')->where('void', '0')->get();
      $data['grandparents'] = $grandparents;
      return view('admin/viewmcograndparent',$data);
    }
}
