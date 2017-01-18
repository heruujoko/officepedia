<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MConfig;
class GeneralJournalController extends Controller
{
    public function index(){
        $data['section'] = "Jurnal Umum";
        $data['active'] = "generaljournal";
        $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return view('admin.generaljournal',$data);
    }
}
