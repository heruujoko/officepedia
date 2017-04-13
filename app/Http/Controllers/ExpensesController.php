<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\MCOA;
use App\MJournal;
use Carbon\Carbon;
use App\MConfig;
use PDF;
use Excel;

class ExpensesController extends Controller
{
  public function index(){
      if(Auth::user()->has_role('R_journal')){
          $data['active'] = 'expenses';
          $data['section'] = 'Biaya';
          $data['config'] = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
          return view('admin.expensesreport',$data);
      } else {
          return redirect('/admin-nano/index');
      }
  }
}
