<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MConfig;
use App\MCOA;
use Auth;
use App\Helper\DBHelper;

class MConfigController extends Controller
{
    public function sysparam(){
        if(Auth::user()->has_role('R_config')){
            DBHelper::configureConnection(Auth::user()->db_alias);
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $data['active'] = 'sysparam';
            $data['section'] = 'Parameter Sistem';
            return view('admin.viewconfigsysparam',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }

    public function sysfeature(){
        if(Auth::user()->has_role('R_config')){
            DBHelper::configureConnection(Auth::user()->db_alias);
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $data['active'] = 'sysfeature';
            $data['section'] = 'Setting Fitur';
            $data['mcoa'] = MCOA::on(Auth::user()->db_name)->get();
            return view('admin.viewconfigsysfeature',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }
}
