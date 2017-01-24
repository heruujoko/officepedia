<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use Auth;

class RoleController extends Controller
{
    public function index(){
        $data['section'] = "Hak Akses";
        $data['active'] = "roles";
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.roles',$data);
    }
}
