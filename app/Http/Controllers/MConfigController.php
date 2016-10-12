<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use App\MCOA;
class MConfigController extends Controller
{
    public function sysparam(){
      $data['config'] = MConfig::find(1);
      $data['active'] = 'sysparam';
      $data['section'] = 'Parameter Sistem';
      return view('admin.viewconfigsysparam',$data);
    }

    public function sysfeature(){
      $data['config'] = MConfig::find(1);
      $data['active'] = 'sysfeature';
      $data['section'] = 'Setting Fitur';
      $data['mcoa'] = MCOA::all();
      return view('admin.viewconfigsysfeature',$data);
    }
}
