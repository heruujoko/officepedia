<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCOAParent;
use App\MCOAGrandParent;

class MCOAController extends Controller
{
    public function index(){
      $data['active'] = 'mcoa';
      $data['section'] = 'MCOA';
      $data['parents'] = MCOAParent::all();
      $data['gparents'] = MCOAGrandParent::all();

      return view('admin/viewmcoa',$data);
    }
}
