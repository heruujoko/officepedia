<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;
class GeneralJournalController extends Controller
{
    public function index(){

        if(Auth::user()->has_role('R_generaljournal')){
            $data['section'] = "Jurnal Umum";
            $data['active'] = "generaljournal";
            $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            return view('admin.generaljournal',$data);
        } else {
            return redirect('/admin-nano/index');
        }
    }
}
