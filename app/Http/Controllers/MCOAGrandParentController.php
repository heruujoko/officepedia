<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class MCOAGrandParentController extends Controller {
    public function index(){
      $grandparents = DB::table('mcoagrandparent')->orderby('created_at','desc')->where('void', '0')->get();
      $data['active'] = 'mcoagp';
      $data['grandparents'] = $grandparents;
      $data['section'] = 'MCOA Grand Parent';
      return view('admin/viewmcograndparent',$data);
    }
}
