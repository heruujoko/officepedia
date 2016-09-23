<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCOA;

class MPrefixController extends Controller
{
    public function index(){
      $data['transactions'] = MCOA::all();
      $data['active'] = "mprefix";
      $data['section'] = "MPrefix";
      return view('admin/viewmprefix',$data);
    }
}
