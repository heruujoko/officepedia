<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCOAParent;

class MCOAController extends Controller
{
    public function index(){
      $data['section'] = 'MCOA';
      $data['parents'] = MCOAParent::all();

      return view('admin/viewmcoa',$data);
    }
}
