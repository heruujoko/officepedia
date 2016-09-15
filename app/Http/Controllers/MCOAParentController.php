<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCOAGrandParent;
class MCOAParentController extends Controller
{
    public function index(){
      $data['section'] = 'MCOA Parent';
      $data['grandparents'] = MCOAGrandParent::all();
      return view('admin/viewmcoaparent',$data);
    }
}
